@php
    $hasSocial = !empty($shop->facebook) || !empty($shop->instagram) || !empty($shop->tiktok) || !empty($shop->x_twitter) || !empty($shop->telegram);
    $hasContact = !empty($shop->contact_phone) || !empty($shop->contact_sms);
    $hasOperaciones = ($shop->delivery_rate_per_km ?? 0) > 0
        || !empty($shop->latitude)
        || $shop->has_dine_in
        || $shop->has_pickup
        || $shop->has_delivery
        || ($shop->enable_free_shipping ?? false);
    $dbAmenitiesCheck = $shop->amenities ?? [];
    $hasAmenities = collect($dbAmenitiesCheck)->contains(fn ($a) => is_array($a) && !empty($a['enabled']));
    $whRaw = $shop->work_hours;
    if (is_string($whRaw)) {
        $whDecoded = json_decode($whRaw, true);
        $whRaw = $whDecoded ?? $whRaw;
    }
    $hasHorario = (is_array($whRaw) && (!empty($whRaw['text']) || (($whRaw['type'] ?? '') === 'custom')))
        || (is_string($whRaw) && trim((string) $whRaw) !== '');
    $paymentMethodsCheck = $shop->payment_methods ? json_decode($shop->payment_methods, true) : [];
    $hasPagos = !empty($paymentMethodsCheck)
        || $shop->cashea_enabled
        || $shop->cashea_link_enabled
        || !empty($shop->cashea_qr_path)
        || !empty($shop->cashea_link_url)
        || $shop->krece_enabled
        || $shop->krece_link_enabled
        || !empty($shop->krece_qr_path)
        || !empty($shop->krece_link_url);
@endphp

<div id="content-comercio" class="tab-content active space-y-4 md:space-y-5 pt-0.5"
     x-data="{
         sections: {
             esencial: true,
             redes: {{ $hasSocial || $hasContact ? 'true' : 'false' }},
             operaciones: {{ $hasOperaciones ? 'true' : 'false' }},
             comodidades: {{ $hasAmenities ? 'true' : 'false' }},
             horario: {{ $hasHorario ? 'true' : 'false' }},
             pagos: {{ $hasPagos ? 'true' : 'false' }}
         },
         openPanel: 'esencial',
         togglePanel(id) {
             this.openPanel = this.openPanel === id ? null : id;
         },
         enableSection(id) {
             this.sections[id] = true;
             this.openPanel = id;
             this.$nextTick(() => {
                 document.getElementById('settings-section-' + id)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
             });
         },
         activeCount() {
             return Object.values(this.sections).filter(Boolean).length;
         }
     }">

    <div class="rounded-2xl border border-primary/15 bg-gradient-to-br from-primary/[0.06] to-transparent p-4 sm:p-5 md:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 md:gap-4">
            <div>
                <h3 class="text-sm md:text-lg font-black text-slate-800 dark:text-slate-100">
                    Configura tu tienda paso a paso
                </h3>
                <p class="text-[11px] md:text-sm text-slate-500 dark:text-slate-400 mt-1 max-w-xl leading-relaxed">
                    Empieza con lo esencial. Activa solo los bloques que necesites para
                    <span class="font-bold text-slate-700 dark:text-slate-200">{{ $shop->name }}</span>.
                </p>
            </div>
            <span class="text-xs md:text-sm font-black text-primary px-3 py-1 md:px-3.5 md:py-1.5 rounded-full bg-primary/10 border border-primary/20 shrink-0"
                  x-text="activeCount() + ' / 6 activos'"></span>
        </div>
        <div class="flex flex-wrap gap-1.5 md:gap-2 mt-3 md:mt-4">
            <template x-for="item in [
                { id: 'esencial', label: 'Esencial' },
                { id: 'redes', label: 'Redes' },
                { id: 'operaciones', label: 'Delivery' },
                { id: 'comodidades', label: 'Local' },
                { id: 'horario', label: 'Horario' },
                { id: 'pagos', label: 'Pagos' }
            ]" :key="item.id">
                <button type="button"
                        @click="sections[item.id] ? (openPanel = item.id) : enableSection(item.id)"
                        class="text-[10px] md:text-xs font-bold px-2.5 py-1 md:px-3 md:py-1.5 rounded-lg border transition-all"
                        :class="sections[item.id]
                            ? (openPanel === item.id ? 'bg-primary text-white border-primary' : 'ui-surface text-slate-700 dark:text-slate-200 border-slate-200 dark:border-slate-700')
                            : 'bg-slate-100 dark:bg-slate-800 text-slate-400 border-transparent'">
                    <span x-text="item.label"></span>
                </button>
            </template>
        </div>
    </div>

    <div class="space-y-3 md:space-y-4">
        <div id="settings-section-esencial">
            <x-settings-section id="esencial" title="Información esencial"
                subtitle="Nombre, categoría, WhatsApp, ubicación y enlace corto para compartir." icon="🏪" :optional="false">
                @include('partials.settings.comercio.esencial')
            </x-settings-section>
        </div>

        <div id="settings-section-redes">
            <x-settings-section id="redes" title="Redes y contacto extra"
                subtitle="Redes sociales y teléfonos alternativos." icon="📱">
                @include('partials.settings.comercio.redes-contacto')
            </x-settings-section>
        </div>

        <div id="settings-section-operaciones">
            <x-settings-section id="operaciones" title="Delivery y operaciones"
                subtitle="Tarifas, tasa BCV, GPS y tipos de servicio." icon="🛵">
                @include('partials.settings.comercio.operaciones')
            </x-settings-section>
        </div>

        <div id="settings-section-comodidades">
            <x-settings-section id="comodidades" title="Comodidades del local"
                subtitle="Wi-Fi, estacionamiento, mascotas y más." icon="✨">
                @include('partials.settings.comercio.comodidades')
            </x-settings-section>
        </div>

        <div id="settings-section-horario">
            <x-settings-section id="horario" title="Horario de atención"
                subtitle="Texto simple o horario detallado por día." icon="🕐">
                @include('partials.settings.comercio.horario')
            </x-settings-section>
        </div>

        <div id="settings-section-pagos">
            <x-settings-section id="pagos" title="Métodos de pago"
                subtitle="Efectivo, Pago Móvil, Zelle, Cashea (QR o link) y datos para el cliente." icon="💳">
                @include('partials.settings.comercio.pagos')
            </x-settings-section>
        </div>
    </div>
</div>
