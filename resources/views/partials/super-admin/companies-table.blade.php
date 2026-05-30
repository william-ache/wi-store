@php
    $categoryLabels = [
        'gastronomia' => ['🍽️', 'Gastronomía'],
        'moda_estilo' => ['👗', 'Moda'],
        'detalles_regalos' => ['🎁', 'Regalos'],
        'servicios' => ['🔧', 'Servicios'],
        'otros' => ['📦', 'Otros'],
    ];
@endphp

<section class="sa-companies-table">
    <div class="sa-companies-table__head">
        <div>
            <h2 class="sa-companies-table__title">
                <i class="fas fa-store text-purple-600" aria-hidden="true"></i>
                Tiendas registradas
            </h2>
            <p class="sa-companies-table__desc">Activa, edita planes y gestiona el acceso de cada empresa.</p>
        </div>
        <div class="sa-companies-table__actions">
            <span class="sa-count-badge">{{ $shops->count() }} empresas</span>
            <button type="button" @click="showCreateModal = true" class="sa-btn-primary text-xs px-4 py-2.5 inline-flex items-center gap-2">
                <i class="fas fa-plus" aria-hidden="true"></i>
                Agregar empresa
            </button>
        </div>
    </div>

    <div class="sa-table-wrap">
        <table id="shops-table" class="sa-table display w-full">
            <thead>
                <tr>
                    <th class="sa-table__th sa-table__th--shop">Tienda</th>
                    <th class="sa-table__th">Categoría</th>
                    <th class="sa-table__th">Administrador</th>
                    <th class="sa-table__th sa-table__th--plan">Plan</th>
                    <th class="sa-table__th">Último pago</th>
                    <th class="sa-table__th">Vencimiento</th>
                    <th class="sa-table__th sa-table__th--center">Estado</th>
                    <th class="sa-table__th sa-table__th--actions">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shops as $shop)
                    @php
                        $cat = $categoryLabels[$shop->shop_category] ?? ['📦', 'Sin categoría'];
                        $shopDataJson = json_encode([
                            'id' => $shop->id,
                            'name' => $shop->name,
                            'slug' => $shop->slug,
                            'whatsapp_number' => $shop->whatsapp_number,
                            'plan' => $shop->plan,
                            'shop_category' => $shop->shop_category ?? 'otros',
                            'billing_cycle' => $shop->billing_cycle ?? 'mensual',
                            'plan_expires_at' => $shop->plan_expires_at ? $shop->plan_expires_at->format('Y-m-d') : '',
                            'last_payment_date' => $shop->last_payment_date ? $shop->last_payment_date->format('Y-m-d') : '',
                            'last_payment_amount' => $shop->last_payment_amount ?? '',
                            'color_primary' => $shop->color_primary,
                            'color_secondary' => $shop->color_secondary,
                            'color_background' => $shop->color_background,
                            'logo_path' => $shop->logo_path,
                            'cover_path' => $shop->cover_path,
                            'description' => $shop->description,
                            'address' => $shop->address,
                            'enabled_modules' => $shop->enabled_modules ?? [],
                            'users' => $shop->users->map(fn ($u) => ['email' => $u->email, 'temp_password' => $u->temp_password]),
                        ]);
                    @endphp
                    <tr>
                        <td data-order="{{ $shop->name }}">
                            <div class="sa-shop-cell">
                                <div class="sa-shop-cell__logo">
                                    @if ($shop->logo_path)
                                        <img src="{{ filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : asset('storage/' . $shop->logo_path) }}"
                                             alt="" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-store text-slate-400 text-sm" aria-hidden="true"></i>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="sa-shop-cell__name">{{ $shop->name }}</p>
                                    <a href="/{{ $shop->slug }}" target="_blank" rel="noopener"
                                       class="sa-shop-cell__slug">/{{ $shop->slug }}</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="sa-pill sa-pill--neutral">
                                <span aria-hidden="true">{{ $cat[0] }}</span>
                                {{ $cat[1] }}
                            </span>
                        </td>
                        <td>
                            <span class="sa-cell-email" title="{{ $shop->users->first()->email ?? '' }}">
                                {{ $shop->users->first()->email ?? '—' }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('super-admin.shops.update-plan', $shop->id) }}" method="POST"
                                  class="sa-plan-form" @change="$event.target.form.requestSubmit()">
                                @csrf
                                @method('PATCH')
                                <select name="plan" class="sa-select sa-select--sm" aria-label="Plan de {{ $shop->name }}">
                                    <option value="free_trial" @selected($shop->plan === 'free_trial')>Prueba {{ $wiStoreTrialDays }}d</option>
                                    <option value="standard" @selected($shop->plan === 'standard')>Emprendedor</option>
                                    <option value="premium" @selected($shop->plan === 'premium')>Negocio</option>
                                </select>
                                @if ($shop->plan !== 'free_trial')
                                    <select name="billing_cycle" class="sa-select sa-select--xs" aria-label="Ciclo de {{ $shop->name }}">
                                        <option value="mensual" @selected(($shop->billing_cycle ?? 'mensual') === 'mensual')>Mensual</option>
                                        <option value="anual" @selected($shop->billing_cycle === 'anual')>Anual</option>
                                    </select>
                                @endif
                            </form>
                        </td>
                        <td>
                            @if ($shop->last_payment_amount)
                                <div class="sa-payment-cell">
                                    <span class="sa-pill sa-pill--success">${{ number_format($shop->last_payment_amount, 2) }}</span>
                                    @if ($shop->last_payment_date)
                                        <span class="sa-cell-muted">{{ $shop->last_payment_date->format('d/m/Y') }}</span>
                                    @endif
                                </div>
                            @else
                                <span class="sa-cell-muted">Sin registro</span>
                            @endif
                        </td>
                        <td>
                            @if ($shop->plan_expires_at)
                                @php
                                    $isExpired = $shop->plan_expires_at->isPast();
                                    $isExpiringSoon = !$isExpired && $shop->plan_expires_at->lte(now()->addMonth());
                                @endphp
                                @if ($isExpired)
                                    <span class="sa-pill sa-pill--danger">Vencido · {{ $shop->plan_expires_at->format('d/m/Y') }}</span>
                                @elseif ($isExpiringSoon)
                                    <span class="sa-pill sa-pill--warning">Pronto por vencer · {{ $shop->plan_expires_at->format('d/m/Y') }}</span>
                                @else
                                    <span class="sa-pill sa-pill--neutral">{{ $shop->plan_expires_at->format('d/m/Y') }}</span>
                                @endif
                            @else
                                <span class="sa-cell-muted">Sin límite</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($shop->is_active)
                                <span class="sa-pill sa-pill--success sa-pill--dot">Activo</span>
                            @else
                                <span class="sa-pill sa-pill--danger sa-pill--dot">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div class="sa-row-actions">
                                <button type="button" @click="openEdit({{ $shopDataJson }})"
                                        class="sa-action-btn sa-action-btn--primary" title="Gestionar tienda">
                                    <i class="fas fa-pen-to-square" aria-hidden="true"></i>
                                    <span>Gestionar</span>
                                </button>
                                <form action="{{ route('super-admin.shops.toggle', $shop->id) }}" method="POST" class="inline">
                                    @csrf
                                    @if ($shop->is_active)
                                        <button type="submit" class="sa-action-btn sa-action-btn--danger" title="Desactivar tienda"
                                                onclick="return confirm('¿Desactivar {{ $shop->name }}?');">
                                            <i class="fas fa-ban" aria-hidden="true"></i>
                                            <span>Desactivar</span>
                                        </button>
                                    @else
                                        <button type="submit" class="sa-action-btn sa-action-btn--success" title="Activar tienda">
                                            <i class="fas fa-check" aria-hidden="true"></i>
                                            <span>Activar</span>
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="sa-table-empty">
                            <i class="fas fa-store text-2xl text-slate-300 mb-2" aria-hidden="true"></i>
                            <p>No hay tiendas registradas aún.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
