<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminExcelService;
use App\Support\AdminExcel\AdminExcelRegistry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminExcelController extends Controller
{
    public function __construct(
        private readonly AdminExcelService $excelService
    ) {}

    public function export(string $entity): StreamedResponse
    {
        AdminExcelRegistry::get($entity);

        return $this->excelService->downloadExport($entity);
    }

    public function template(string $entity): StreamedResponse
    {
        AdminExcelRegistry::get($entity);

        return $this->excelService->downloadTemplate($entity);
    }

    public function import(Request $request, string $entity): RedirectResponse
    {
        AdminExcelRegistry::get($entity);

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ], [
            'file.required' => 'Selecciona un archivo Excel para importar.',
            'file.mimes' => 'El archivo debe ser Excel (.xlsx, .xls) o CSV.',
            'file.max' => 'El archivo no puede superar 10 MB.',
        ]);

        $result = $this->excelService->import($entity, $request->file('file'));

        $message = sprintf(
            'Importación finalizada: %d creados, %d actualizados.',
            $result['created'],
            $result['updated']
        );

        if (count($result['errors']) > 0) {
            $message .= ' ' . count($result['errors']) . ' fila(s) con error.';
        }

        return redirect()
            ->back()
            ->with('excel_result', $result)
            ->with(count($result['errors']) > 0 ? 'warning' : 'success', $message);
    }
}
