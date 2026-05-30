@props(['mode' => 'edit'])

@php
    $isEdit = $mode === 'edit';
@endphp

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    {{-- Columna: información general --}}
    <div class="sa-form-col">
        <h3 class="sa-form-section-title">Información general</h3>

        <div class="sa-form-group">
            <label class="sa-form-label" for="{{ $isEdit ? 'edit-name' : 'create-name' }}">Nombre de la tienda</label>
            <div class="sa-field-wrap">
                <i class="fas fa-shop sa-field-wrap__icon" aria-hidden="true"></i>
                <input type="text" name="name" id="{{ $isEdit ? 'edit-name' : 'create-name' }}" required
                    placeholder="Ej: Sabores Y&B"
                    @if ($isEdit) x-model="editingShop.name" @else value="{{ old('name') }}" @endif
                    class="sa-modal-field sa-modal-field--icon">
            </div>
        </div>

        <div class="sa-form-group">
            <label class="sa-form-label" for="{{ $isEdit ? 'edit-whatsapp' : 'create-whatsapp' }}">WhatsApp de pedidos</label>
            <div class="sa-field-wrap">
                <i class="fab fa-whatsapp sa-field-wrap__icon" aria-hidden="true"></i>
                <input type="text" name="whatsapp_number" id="{{ $isEdit ? 'edit-whatsapp' : 'create-whatsapp' }}" required
                    placeholder="Ej: +584121234567"
                    @if ($isEdit) x-model="editingShop.whatsapp_number" @else value="{{ old('whatsapp_number') }}" @endif
                    class="sa-modal-field sa-modal-field--icon">
            </div>
        </div>

        <div class="sa-form-group">
            <label class="sa-form-label">Categoría de la tienda</label>
            @if ($isEdit)
                @include('partials.super-admin.shop-category-select', ['model' => 'editingShop.shop_category'])
            @else
                @include('partials.super-admin.shop-category-select', ['selected' => old('shop_category', 'otros')])
            @endif
        </div>

        <div class="sa-form-group">
            <label class="sa-form-label">Plan de suscripción</label>
            <div class="sa-field-wrap">
                <i class="fas fa-crown sa-field-wrap__icon" aria-hidden="true"></i>
                <select name="plan" required
                    @if ($isEdit) x-model="editingShop.plan" @change="syncShopModulesToPlan(editingShop)" @else x-model="createPlan" @change="trimCreateModulesToPlan()" @endif
                    class="sa-modal-field sa-modal-field--icon sa-modal-field--select">
                    <option value="free_trial">Prueba gratis ({{ $wiStoreTrialDays }} días)</option>
                    <option value="standard">Plan Emprendedor</option>
                    <option value="premium">Plan Negocio</option>
                </select>
            </div>
        </div>

        <div class="sa-form-group" @if ($isEdit) x-show="editingShop.plan !== 'free_trial'" @else x-show="createPlan !== 'free_trial'" @endif x-transition>
            <label class="sa-form-label">Frecuencia de facturación</label>
            <div class="sa-field-wrap">
                <i class="fas fa-arrows-spin sa-field-wrap__icon" aria-hidden="true"></i>
                <select name="billing_cycle" required
                    @if ($isEdit) x-model="editingShop.billing_cycle" @else x-model="createBillingCycle" @endif
                    class="sa-modal-field sa-modal-field--icon sa-modal-field--select">
                    <option value="mensual">Pago mensual</option>
                    <option value="anual">Pago anual</option>
                </select>
            </div>
        </div>

        <div class="sa-modal-subsection">
            <h4 class="sa-form-subtitle">{{ $isEdit ? 'Detalles de suscripción' : 'Suscripción inicial' }}</h4>
            <div class="sa-form-row-2">
                <div class="sa-form-group">
                    <label class="sa-form-label">Fecha límite</label>
                    <div class="sa-field-wrap">
                        <i class="fas fa-calendar-day sa-field-wrap__icon" aria-hidden="true"></i>
                        <input type="date" name="plan_expires_at"
                            @if ($isEdit) x-model="editingShop.plan_expires_at" @else value="{{ old('plan_expires_at', now()->addDays(30)->format('Y-m-d')) }}" @endif
                            class="sa-modal-field sa-modal-field--icon sa-modal-field--date">
                    </div>
                </div>
                <div class="sa-form-group">
                    <label class="sa-form-label">Fecha de pago</label>
                    <div class="sa-field-wrap">
                        <i class="fas fa-calendar-check sa-field-wrap__icon" aria-hidden="true"></i>
                        <input type="date" name="last_payment_date"
                            @if ($isEdit) x-model="editingShop.last_payment_date" @else value="{{ old('last_payment_date', now()->format('Y-m-d')) }}" @endif
                            class="sa-modal-field sa-modal-field--icon sa-modal-field--date">
                    </div>
                </div>
            </div>
            <div class="sa-form-group">
                <label class="sa-form-label">Monto de pago (USD)</label>
                <div class="sa-field-wrap">
                    <i class="fas fa-dollar-sign sa-field-wrap__icon" aria-hidden="true"></i>
                    <input type="number" step="0.01" min="0" name="last_payment_amount"
                        placeholder="{{ $isEdit ? 'Ej: 14.99' : 'Vacío = monto del plan' }}"
                        @if ($isEdit) x-model="editingShop.last_payment_amount" @endif
                        class="sa-modal-field sa-modal-field--icon">
                </div>
            </div>
        </div>

        <div class="sa-form-group">
            <label class="sa-form-label">Descripción</label>
            <textarea name="description" rows="3" placeholder="Breve descripción del negocio…"
                @if ($isEdit) x-model="editingShop.description" @endif
                class="sa-modal-field sa-modal-field--textarea">{{ $isEdit ? '' : old('description') }}</textarea>
        </div>

        <div class="sa-form-group">
            <label class="sa-form-label">Dirección física</label>
            <textarea name="address" rows="2" placeholder="Dirección del local (opcional)…"
                @if ($isEdit) x-model="editingShop.address" @endif
                class="sa-modal-field sa-modal-field--textarea">{{ $isEdit ? '' : old('address') }}</textarea>
        </div>

        @include('partials.super-admin.company-modules-field', ['mode' => $mode])
    </div>

    {{-- Columna: administración y estilos --}}
    <div class="sa-form-col">
        <h3 class="sa-form-section-title">Administración y estilos</h3>

        <div class="sa-modal-subsection">
            <h4 class="sa-form-subtitle">Acceso del administrador</h4>

            <div class="sa-form-group">
                <label class="sa-form-label">Correo del administrador</label>
                <div class="sa-field-wrap">
                    <i class="fas fa-envelope sa-field-wrap__icon" aria-hidden="true"></i>
                    <input type="email" name="email" required placeholder="admin@tienda.com"
                        @if ($isEdit) x-model="editingShop.email" @else value="{{ old('email') }}" @endif
                        class="sa-modal-field sa-modal-field--icon">
                </div>
            </div>

            @if ($isEdit)
                <div class="sa-password-panel">
                    <div class="sa-form-group">
                        <label class="sa-form-label">Nueva contraseña</label>
                        <p class="sa-form-hint">Déjala vacía si no quieres cambiar la contraseña de acceso.</p>
                        <div class="sa-field-wrap">
                            <i class="fas fa-lock sa-field-wrap__icon" aria-hidden="true"></i>
                            <input :type="showPassword ? 'text' : 'password'" name="password"
                                placeholder="Nueva contraseña (opcional)"
                                class="sa-modal-field sa-modal-field--icon">
                        </div>
                    </div>
                    <div class="sa-password-panel__current">
                        <span class="sa-form-label">Contraseña temporal guardada</span>
                        <code class="sa-temp-password">
                            <span x-text="showPassword ? (editingShop.temp_password || 'Sin registrar') : '••••••••'"></span>
                            <button type="button" @click="showPassword = !showPassword" class="sa-temp-password__toggle"
                                aria-label="Mostrar u ocultar">
                                <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </code>
                    </div>
                </div>
            @else
                <div class="sa-form-group">
                    <label class="sa-form-label">Contraseña de acceso</label>
                    <p class="sa-form-hint">Mínimo 6 caracteres. Se mostrará al crear la tienda.</p>
                    <div class="sa-field-wrap">
                        <i class="fas fa-lock sa-field-wrap__icon" aria-hidden="true"></i>
                        <input type="password" name="password" required placeholder="Contraseña del administrador"
                            class="sa-modal-field sa-modal-field--icon">
                    </div>
                </div>
            @endif
        </div>

        <div class="sa-form-group">
            <label class="sa-form-label">Colores de marca</label>
            <div class="sa-color-grid">
                <label class="sa-color-card">
                    <span class="sa-color-card__label">Primario</span>
                    <input type="color" name="color_primary" class="sa-color-card__input"
                        @if ($isEdit) x-model="editingShop.color_primary" @else value="{{ old('color_primary', '#E60067') }}" @endif>
                </label>
                <label class="sa-color-card">
                    <span class="sa-color-card__label">Secundario</span>
                    <input type="color" name="color_secondary" class="sa-color-card__input"
                        @if ($isEdit) x-model="editingShop.color_secondary" @else value="{{ old('color_secondary', '#0B132B') }}" @endif>
                </label>
                <label class="sa-color-card">
                    <span class="sa-color-card__label">Fondo</span>
                    <input type="color" name="color_background" class="sa-color-card__input"
                        @if ($isEdit) x-model="editingShop.color_background" @else value="{{ old('color_background', '#FFF0F8') }}" @endif>
                </label>
            </div>
            <label class="sa-form-label mt-3">Texto sobre color primario</label>
            <select name="text_on_primary" class="sa-modal-field mt-1"
                @if ($isEdit) x-model="editingShop.text_on_primary" @endif>
                <option value="white" @if (!$isEdit && old('text_on_primary', 'white') === 'white') selected @endif>Blanco</option>
                <option value="auto" @if (!$isEdit && old('text_on_primary') === 'auto') selected @endif>Automático</option>
                <option value="black" @if (!$isEdit && old('text_on_primary') === 'black') selected @endif>Negro</option>
            </select>
        </div>

        <div class="sa-form-group">
            <label class="sa-form-label">Imágenes de la tienda</label>
            <div class="sa-media-stack">
                <div class="sa-media-block">
                    <div class="sa-media-block__head">
                        <span class="sa-media-block__title"><i class="fas fa-image" aria-hidden="true"></i> Logo</span>
                        @if ($isEdit)
                            <div class="sa-media-block__preview" x-show="editingShop.logo_path" x-cloak>
                                <img :src="editingShop.logo_path && editingShop.logo_path.startsWith('http') ? editingShop.logo_path : '/storage/' + editingShop.logo_path"
                                     alt="" class="sa-media-block__thumb">
                            </div>
                        @endif
                    </div>
                    <label class="sa-file-label">
                        <span class="sa-file-label__text">Subir archivo</span>
                        <input type="file" name="logo" accept="image/*" class="sa-modal-file">
                    </label>
                    <p class="sa-form-hint sa-form-hint--inline">O usa una URL pública:</p>
                    <input type="text" name="logo_url" placeholder="https://…"
                        @if ($isEdit) x-model="editingShop.logo_path" @else value="{{ old('logo_url') }}" @endif
                        class="sa-modal-field">
                </div>
                <div class="sa-media-block">
                    <div class="sa-media-block__head">
                        <span class="sa-media-block__title"><i class="fas fa-panorama" aria-hidden="true"></i> Portada</span>
                        @if ($isEdit)
                            <div class="sa-media-block__preview" x-show="editingShop.cover_path" x-cloak>
                                <img :src="editingShop.cover_path && editingShop.cover_path.startsWith('http') ? editingShop.cover_path : '/storage/' + editingShop.cover_path"
                                     alt="" class="sa-media-block__thumb sa-media-block__thumb--wide">
                            </div>
                        @endif
                    </div>
                    <label class="sa-file-label">
                        <span class="sa-file-label__text">Subir archivo</span>
                        <input type="file" name="cover" accept="image/*" class="sa-modal-file">
                    </label>
                    <p class="sa-form-hint sa-form-hint--inline">O usa una URL pública:</p>
                    <input type="text" name="cover_url" placeholder="https://…"
                        @if ($isEdit) x-model="editingShop.cover_path" @else value="{{ old('cover_url') }}" @endif
                        class="sa-modal-field">
                </div>
            </div>
        </div>
    </div>
</div>
