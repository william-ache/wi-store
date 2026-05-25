<?php

namespace App\Services;

use App\Models\AbandonedCart;
use App\Models\Announcement;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Client;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Support\AdminExcel\AdminExcelRegistry;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminExcelService
{
    /**
     * @return StreamedResponse
     */
    public function downloadExport(string $entity): StreamedResponse
    {
        $config = AdminExcelRegistry::get($entity);
        $rows = $this->fetchExportRows($entity);
        $columns = $config['columns'];

        return $this->streamSpreadsheet(
            $columns,
            $rows,
            $this->buildFilename($config['filename'], 'export')
        );
    }

    /**
     * @return StreamedResponse
     */
    public function downloadTemplate(string $entity): StreamedResponse
    {
        $config = AdminExcelRegistry::get($entity);
        $columns = array_values(array_filter(
            $config['columns'],
            fn (array $col) => ($col['import'] ?? true) && ($col['key'] ?? '') !== 'id'
        ));

        return $this->streamSpreadsheet(
            $columns,
            [],
            $this->buildFilename($config['filename'], 'plantilla')
        );
    }

    /**
     * @return array{created: int, updated: int, skipped: int, errors: list<string>}
     */
    public function import(string $entity, UploadedFile $file): array
    {
        $config = AdminExcelRegistry::get($entity);

        if (! ($config['importable'] ?? true)) {
            return [
                'created' => 0,
                'updated' => 0,
                'skipped' => 0,
                'errors' => ['Esta entidad no admite importación.'],
            ];
        }

        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);

        if (count($sheetData) < 2) {
            return [
                'created' => 0,
                'updated' => 0,
                'skipped' => 0,
                'errors' => ['El archivo está vacío o solo contiene encabezados.'],
            ];
        }

        $headerRow = array_shift($sheetData);
        $columnMap = $this->mapHeaders($headerRow, $config['columns']);

        $result = ['created' => 0, 'updated' => 0, 'skipped' => 0, 'errors' => []];

        foreach ($sheetData as $index => $row) {
            $line = $index + 2;
            $data = $this->rowToAssoc($columnMap, $row);

            if ($this->isEmptyRow($data)) {
                continue;
            }

            try {
                $action = $this->importRow($entity, $data);
                $result[$action]++;
            } catch (\Throwable $e) {
                $result['errors'][] = "Fila {$line}: {$e->getMessage()}";
            }
        }

        return $result;
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function fetchExportRows(string $entity): array
    {
        return match ($entity) {
            'categories' => Category::withCount('products')->orderBy('name')->get()
                ->map(fn (Category $c) => [
                    'id' => $c->id,
                    'name' => $c->name,
                    'slug' => $c->slug,
                    'seo_title' => $c->seo_title,
                    'seo_description' => $c->seo_description,
                    'status' => $c->status ? 1 : 0,
                    'icon' => $c->icon,
                    'color' => $c->color,
                    'products_count' => $c->products_count,
                ])->all(),
            'products' => Product::with('category')->orderBy('name')->get()
                ->map(fn (Product $p) => [
                    'id' => $p->id,
                    'category_name' => $p->category?->name,
                    'name' => $p->name,
                    'description' => $p->description,
                    'price' => $p->price,
                    'is_available' => $p->is_available ? 1 : 0,
                    'preparation_time' => $p->preparation_time,
                    'features' => $p->features ? json_encode($p->features, JSON_UNESCAPED_UNICODE) : '',
                    'seo_title' => $p->seo_title,
                    'seo_description' => $p->seo_description,
                    'image_path' => $p->image_path,
                ])->all(),
            'orders' => Order::with('client')->orderByDesc('id')->get()
                ->map(fn (Order $o) => [
                    'id' => $o->id,
                    'order_number' => $o->order_number,
                    'customer_name' => $o->customer_name,
                    'customer_phone' => $o->customer_phone,
                    'total' => $o->total,
                    'status' => $o->status,
                    'payment_method' => $o->payment_method,
                    'payment_status' => $o->payment_status,
                    'delivery_type' => $o->delivery_type,
                    'table_number' => $o->table_number,
                    'payment_reference' => $o->payment_reference,
                    'client_phone' => $o->client?->phone,
                    'created_at' => $o->created_at?->format('Y-m-d H:i'),
                ])->all(),
            'clients' => Client::orderBy('name')->get()
                ->map(fn (Client $c) => [
                    'id' => $c->id,
                    'name' => $c->name,
                    'phone' => $c->phone,
                    'email' => $c->email,
                    'total_spent' => $c->total_spent,
                    'status' => $c->status ? 1 : 0,
                ])->all(),
            'announcements' => Announcement::orderByDesc('id')->get()
                ->map(fn (Announcement $a) => [
                    'id' => $a->id,
                    'title' => $a->title,
                    'content' => $a->content,
                    'button_text' => $a->button_text,
                    'button_link' => $a->button_link,
                    'expires_at' => $a->expires_at?->format('Y-m-d'),
                    'is_active' => $a->is_active ? 1 : 0,
                    'image_path' => $a->image_path,
                ])->all(),
            'bookings' => Booking::orderByDesc('date')->get()
                ->map(fn (Booking $b) => [
                    'id' => $b->id,
                    'client_name' => $b->client_name,
                    'client_phone' => $b->client_phone,
                    'date' => $b->date?->format('Y-m-d'),
                    'time_slot' => $b->time_slot,
                    'status' => $b->status,
                ])->all(),
            'abandoned-carts' => AbandonedCart::orderByDesc('updated_at')->get()
                ->map(fn (AbandonedCart $c) => [
                    'id' => $c->id,
                    'customer_name' => $c->customer_name,
                    'customer_phone' => $c->customer_phone,
                    'cart_data' => $c->cart_data ? json_encode($c->cart_data, JSON_UNESCAPED_UNICODE) : '',
                    'status' => $c->status,
                    'updated_at' => $c->updated_at?->format('Y-m-d H:i'),
                ])->all(),
            'coupons' => Coupon::orderBy('code')->get()
                ->map(fn (Coupon $c) => [
                    'id' => $c->id,
                    'code' => $c->code,
                    'type' => $c->type,
                    'value' => $c->value,
                    'min_order_amount' => $c->min_order_amount,
                    'usage_limit' => $c->usage_limit,
                    'used_count' => $c->used_count,
                    'expires_at' => $c->expires_at?->format('Y-m-d'),
                    'is_active' => $c->is_active ? 1 : 0,
                ])->all(),
            default => [],
        };
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function importRow(string $entity, array $data): string
    {
        return match ($entity) {
            'categories' => $this->importCategory($data),
            'products' => $this->importProduct($data),
            'orders' => $this->importOrder($data),
            'clients' => $this->importClient($data),
            'announcements' => $this->importAnnouncement($data),
            'bookings' => $this->importBooking($data),
            'abandoned-carts' => $this->importAbandonedCart($data),
            'coupons' => $this->importCoupon($data),
            default => throw new \RuntimeException('Entidad no soportada.'),
        };
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function importCategory(array $data): string
    {
        $this->requireFields($data, ['name']);

        $payload = [
            'name' => trim((string) $data['name']),
            'seo_title' => $this->nullableString($data, 'seo_title'),
            'seo_description' => $this->nullableString($data, 'seo_description'),
            'status' => $this->parseBool($data['status'] ?? 1),
            'icon' => $this->nullableString($data, 'icon'),
            'color' => $this->nullableString($data, 'color') ?: '#E60067',
            'slug' => $this->nullableString($data, 'slug') ?: Str::slug((string) $data['name']),
        ];

        return $this->upsertById(Category::class, $data, $payload, function (Category $category, array $payload) {
            if (Category::where('slug', $payload['slug'])->where('id', '!=', $category->id)->exists()) {
                $payload['slug'] = $payload['slug'] . '-' . uniqid();
            }
            $category->fill($payload)->save();
        }, function (array $payload) {
            if (Category::where('slug', $payload['slug'])->exists()) {
                $payload['slug'] = $payload['slug'] . '-' . uniqid();
            }

            Category::create($payload);
        });
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function importProduct(array $data): string
    {
        $this->requireFields($data, ['name', 'category_name', 'price']);

        $category = Category::query()
            ->where('name', trim((string) $data['category_name']))
            ->orWhere('slug', Str::slug((string) $data['category_name']))
            ->first();

        if (! $category) {
            throw new \RuntimeException('Categoría no encontrada: ' . $data['category_name']);
        }

        $payload = [
            'category_id' => $category->id,
            'name' => trim((string) $data['name']),
            'description' => $this->nullableString($data, 'description'),
            'price' => $this->parseNumber($data['price']),
            'is_available' => $this->parseBool($data['is_available'] ?? 1),
            'preparation_time' => $this->nullableString($data, 'preparation_time'),
            'features' => $this->parseJsonArray($data['features'] ?? null),
            'seo_title' => $this->nullableString($data, 'seo_title'),
            'seo_description' => $this->nullableString($data, 'seo_description'),
            'image_path' => $this->nullableString($data, 'image_path'),
        ];

        return $this->upsertById(Product::class, $data, $payload);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function importOrder(array $data): string
    {
        $this->requireFields($data, ['customer_name', 'customer_phone', 'total', 'status', 'payment_method', 'payment_status']);

        $payload = [
            'customer_name' => trim((string) $data['customer_name']),
            'customer_phone' => trim((string) $data['customer_phone']),
            'total' => $this->parseNumber($data['total']),
            'status' => trim((string) $data['status']),
            'payment_method' => trim((string) $data['payment_method']),
            'payment_status' => trim((string) $data['payment_status']),
            'delivery_type' => $this->nullableString($data, 'delivery_type'),
            'table_number' => $this->nullableString($data, 'table_number'),
            'payment_reference' => $this->nullableString($data, 'payment_reference'),
        ];

        return $this->upsertById(Order::class, $data, $payload, function (Order $order, array $payload) {
            $order->fill($payload)->save();
        }, function (array $payload) {
            $nextId = (Order::max('id') ?? 0) + 1;
            $payload['order_number'] = '#' . (1000 + $nextId);
            Order::create($payload);
        });
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function importClient(array $data): string
    {
        $this->requireFields($data, ['name', 'phone']);

        $payload = [
            'name' => trim((string) $data['name']),
            'phone' => trim((string) $data['phone']),
            'email' => $this->nullableString($data, 'email'),
            'total_spent' => $this->parseNumber($data['total_spent'] ?? 0),
            'status' => $this->parseBool($data['status'] ?? 1),
        ];

        return $this->upsertById(Client::class, $data, $payload);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function importAnnouncement(array $data): string
    {
        $this->requireFields($data, ['title']);

        $payload = [
            'title' => trim((string) $data['title']),
            'content' => $this->nullableString($data, 'content'),
            'button_text' => $this->nullableString($data, 'button_text'),
            'button_link' => $this->nullableString($data, 'button_link'),
            'expires_at' => $this->parseDate($data['expires_at'] ?? null),
            'is_active' => $this->parseBool($data['is_active'] ?? 1),
            'image_path' => $this->nullableString($data, 'image_path'),
        ];

        return $this->upsertById(Announcement::class, $data, $payload);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function importBooking(array $data): string
    {
        $this->requireFields($data, ['client_name', 'client_phone', 'date', 'time_slot']);

        $payload = [
            'client_name' => trim((string) $data['client_name']),
            'client_phone' => trim((string) $data['client_phone']),
            'date' => $this->parseDate($data['date'], required: true),
            'time_slot' => trim((string) $data['time_slot']),
            'status' => $this->nullableString($data, 'status') ?: 'pending',
        ];

        return $this->upsertById(Booking::class, $data, $payload);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function importAbandonedCart(array $data): string
    {
        $this->requireFields($data, ['customer_name', 'customer_phone']);

        $payload = [
            'customer_name' => trim((string) $data['customer_name']),
            'customer_phone' => trim((string) $data['customer_phone']),
            'cart_data' => $this->parseJsonArray($data['cart_data'] ?? null) ?? [],
            'status' => $this->nullableString($data, 'status') ?: 'pending',
        ];

        return $this->upsertById(AbandonedCart::class, $data, $payload);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function importCoupon(array $data): string
    {
        $this->requireFields($data, ['code', 'type', 'value']);

        $payload = [
            'code' => strtoupper(trim((string) $data['code'])),
            'type' => trim((string) $data['type']),
            'value' => $this->parseNumber($data['value']),
            'min_order_amount' => $this->parseNumber($data['min_order_amount'] ?? 0),
            'usage_limit' => $this->nullableInt($data['usage_limit'] ?? null),
            'expires_at' => $this->parseDate($data['expires_at'] ?? null),
            'is_active' => $this->parseBool($data['is_active'] ?? 1),
        ];

        return $this->upsertById(Coupon::class, $data, $payload, function (Coupon $coupon, array $payload) {
            if (Coupon::where('code', $payload['code'])->where('id', '!=', $coupon->id)->exists()) {
                throw new \RuntimeException('Ya existe un cupón con el código ' . $payload['code']);
            }
            $coupon->fill($payload)->save();
        }, function (array $payload) {
            if (Coupon::where('code', $payload['code'])->exists()) {
                throw new \RuntimeException('Ya existe un cupón con el código ' . $payload['code']);
            }
            $payload['used_count'] = 0;
            Coupon::create($payload);
        });
    }

    /**
     * @param  class-string<Model>  $modelClass
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $payload
     */
    private function upsertById(
        string $modelClass,
        array $data,
        array $payload,
        ?callable $update = null,
        ?callable $create = null
    ): string {
        $id = $this->nullableInt($data['id'] ?? null);

        if ($id) {
            /** @var Model|null $record */
            $record = $modelClass::find($id);
            if ($record) {
                if ($update) {
                    $update($record, $payload);
                } else {
                    $record->fill($payload)->save();
                }

                return 'updated';
            }
        }

        if ($create) {
            $create($payload);
        } else {
            $modelClass::create($payload);
        }

        return 'created';
    }

    /**
     * @param  list<array<string, mixed>>  $columns
     * @param  list<array<string, mixed>>  $rows
     */
    private function streamSpreadsheet(array $columns, array $rows, string $filename): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Datos');

        $brandColor = config('current_shop.color_primary', '#E60067');
        $brandArgb = 'FF' . ltrim(str_replace('#', '', $brandColor), '#');

        foreach ($columns as $colIndex => $column) {
            $cell = $sheet->getCell([$colIndex + 1, 1]);
            $cell->setValue($column['label']);
            $sheet->getStyle($cell->getCoordinate())->applyFromArray([
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => $brandArgb],
                ],
            ]);
            $sheet->getColumnDimensionByColumn($colIndex + 1)->setAutoSize(true);
        }

        foreach ($rows as $rowIndex => $row) {
            foreach ($columns as $colIndex => $column) {
                $key = $column['key'];
                $value = $row[$key] ?? '';
                if (is_array($value)) {
                    $value = json_encode($value, JSON_UNESCAPED_UNICODE);
                }
                $sheet->setCellValue([$colIndex + 1, $rowIndex + 2], $value);
            }
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            (new Xlsx($spreadsheet))->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

  /**
     * @param  list<mixed>  $headerRow
     * @param  list<array<string, mixed>>  $columns
     * @return array<int, string|null>
     */
    private function mapHeaders(array $headerRow, array $columns): array
    {
        $lookup = [];
        foreach ($columns as $column) {
            $lookup[$this->normalizeHeader($column['label'])] = $column['key'];
            $lookup[$this->normalizeHeader($column['key'])] = $column['key'];
        }

        $map = [];
        foreach ($headerRow as $index => $header) {
            $normalized = $this->normalizeHeader((string) $header);
            $map[$index] = $lookup[$normalized] ?? null;
        }

        return $map;
    }

    /**
     * @param  array<int, string|null>  $columnMap
     * @param  list<mixed>  $row
     * @return array<string, mixed>
     */
    private function rowToAssoc(array $columnMap, array $row): array
    {
        $data = [];
        foreach ($columnMap as $index => $key) {
            if ($key === null) {
                continue;
            }
            $data[$key] = $row[$index] ?? null;
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function isEmptyRow(array $data): bool
    {
        foreach ($data as $value) {
            if ($value !== null && trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }

  /**
     * @param  array<string, mixed>  $data
     * @param  list<string>  $fields
     */
    private function requireFields(array $data, array $fields): void
    {
        foreach ($fields as $field) {
            if (! isset($data[$field]) || trim((string) $data[$field]) === '') {
                throw new \RuntimeException("Falta el campo obligatorio: {$field}");
            }
        }
    }

    private function normalizeHeader(string $value): string
    {
        $value = Str::ascii(mb_strtolower(trim($value)));

        return preg_replace('/[^a-z0-9]+/', '_', $value) ?? $value;
    }

    private function buildFilename(string $base, string $suffix): string
    {
        $shop = Str::slug(config('current_shop.slug', 'tienda'));

        return "{$base}_{$shop}_{$suffix}_" . now()->format('Y-m-d') . '.xlsx';
    }

    private function nullableString(array $data, string $key): ?string
    {
        if (! array_key_exists($key, $data)) {
            return null;
        }

        $value = trim((string) ($data[$key] ?? ''));

        return $value === '' ? null : $value;
    }

    private function nullableInt(mixed $value): ?int
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        return (int) $value;
    }

    private function parseBool(mixed $value): bool
    {
        $normalized = mb_strtolower(trim((string) $value));

        return in_array($normalized, ['1', 'true', 'si', 'sí', 'yes', 'activo', 'activa', 'on'], true);
    }

    private function parseNumber(mixed $value): float
    {
        if ($value === null || trim((string) $value) === '') {
            return 0.0;
        }

        $normalized = str_replace([' ', ','], ['', '.'], (string) $value);

        return (float) $normalized;
    }

    private function parseDate(mixed $value, bool $required = false): ?string
    {
        if ($value === null || trim((string) $value) === '') {
            if ($required) {
                throw new \RuntimeException('Fecha obligatoria inválida o vacía.');
            }

            return null;
        }

        try {
            return Carbon::parse((string) $value)->format('Y-m-d');
        } catch (\Throwable) {
            throw new \RuntimeException('Formato de fecha inválido: ' . $value);
        }
    }

    /**
     * @return array<int, mixed>|null
     */
    private function parseJsonArray(mixed $value): ?array
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        if (is_array($value)) {
            return $value;
        }

        $string = trim((string) $value);
        if (str_starts_with($string, '[') || str_starts_with($string, '{')) {
            $decoded = json_decode($string, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return is_array($decoded) ? $decoded : null;
            }
        }

        return array_values(array_filter(array_map('trim', explode('|', $string))));
    }
}
