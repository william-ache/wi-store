                    <!-- Servicios y Comodidades (Amenities) -->
                    <div class="bg-white dark:bg-slate-900/60 p-3.5 rounded-xl border border-slate-150 dark:border-slate-800 space-y-2.5 shadow-sm mt-3">
                        <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider block mb-1">Servicios & Comodidades del Local</span>
                        
                        <div class="grid grid-cols-1 gap-2.5">
                            @php
                                $dbAmenities = $shop->amenities ?? [];
                                $amenitiesList = [
                                    'wifi' => [
                                        'label' => 'Wi-Fi',
                                        'desc' => 'Internet inalámbrico para clientes',
                                        'icon' => 'fas fa-wifi',
                                        'color' => 'blue',
                                        'default' => 'Gratuito'
                                    ],
                                    'parking' => [
                                        'label' => 'Estacionamiento',
                                        'desc' => 'Parqueo para vehículos',
                                        'icon' => 'fas fa-parking',
                                        'color' => 'emerald',
                                        'default' => 'Gratuito'
                                    ],
                                    'restrooms' => [
                                        'label' => 'Baños públicos',
                                        'desc' => 'Sanitarios disponibles',
                                        'icon' => 'fas fa-restroom',
                                        'color' => 'teal',
                                        'default' => 'Gratuito'
                                    ],
                                    'pet_friendly' => [
                                        'label' => 'Pet Friendly',
                                        'desc' => 'Se permiten mascotas',
                                        'icon' => 'fas fa-paw',
                                        'color' => 'indigo',
                                        'default' => 'Sí'
                                    ],
                                    'kids_menu' => [
                                        'label' => 'Menú para Niños',
                                        'desc' => 'Opciones especiales infantiles',
                                        'icon' => 'fas fa-child',
                                        'color' => 'rose',
                                        'default' => 'Disponible'
                                    ],
                                    'reservations' => [
                                        'label' => 'Reservas / Bajo Pedido',
                                        'desc' => 'Platos bajo pedido o mesa reservada',
                                        'icon' => 'fas fa-calendar-alt',
                                        'color' => 'amber',
                                        'default' => 'Bajo pedido'
                                    ],
                                ];
                            @endphp

                            @foreach($amenitiesList as $key => $item)
                                @php
                                    $isEnabled = isset($dbAmenities[$key]['enabled']) ? (bool)$dbAmenities[$key]['enabled'] : false;
                                    $value = isset($dbAmenities[$key]['value']) ? $dbAmenities[$key]['value'] : $item['default'];
                                    
                                    $colorClasses = [
                                        'blue' => 'bg-blue-50/80 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 border-blue-100/60 dark:border-blue-900/30 peer-checked:bg-blue-500',
                                        'emerald' => 'bg-emerald-50/80 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 border-emerald-100/60 dark:border-emerald-900/30 peer-checked:bg-emerald-500',
                                        'teal' => 'bg-teal-50/80 dark:bg-teal-950/20 text-teal-600 dark:text-teal-400 border-teal-100/60 dark:border-teal-900/30 peer-checked:bg-teal-500',
                                        'indigo' => 'bg-indigo-50/80 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 border-indigo-100/60 dark:border-indigo-900/30 peer-checked:bg-indigo-500',
                                        'rose' => 'bg-rose-50/80 dark:bg-rose-950/20 text-rose-600 dark:text-rose-400 border-rose-100/60 dark:border-rose-900/30 peer-checked:bg-rose-500',
                                        'amber' => 'bg-amber-50/80 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 border-amber-100/60 dark:border-amber-900/30 peer-checked:bg-amber-500',
                                    ][$item['color']];

                                    $btnColor = [
                                        'blue' => 'peer-checked:bg-blue-500',
                                        'emerald' => 'peer-checked:bg-emerald-500',
                                        'teal' => 'peer-checked:bg-teal-500',
                                        'indigo' => 'peer-checked:bg-indigo-500',
                                        'rose' => 'peer-checked:bg-rose-500',
                                        'amber' => 'peer-checked:bg-amber-500',
                                    ][$item['color']];
                                @endphp
                                <div class="flex flex-col p-2.5 rounded-xl border border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-900/20 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs {{ explode(' ', $colorClasses)[0] }} {{ explode(' ', $colorClasses)[2] }}">
                                                <i class="{{ $item['icon'] }}"></i>
                                            </span>
                                            <div>
                                                <div class="text-[11px] font-bold text-slate-800 dark:text-slate-200">{{ $item['label'] }}</div>
                                                <div class="text-[9px] text-slate-400 dark:text-slate-500 leading-tight">{{ $item['desc'] }}</div>
                                            </div>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer select-none">
                                            <input type="hidden" name="amenities[{{ $key }}][enabled]" value="0">
                                            <input type="checkbox" name="amenities[{{ $key }}][enabled]" value="1" class="sr-only peer" {{ $isEnabled ? 'checked' : '' }}>
                                            <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all {{ $btnColor }}"></div>
                                        </label>
                                    </div>
                                    <div class="flex items-center gap-2 pl-9">
                                        <span class="text-[9px] font-bold text-slate-400 dark:text-slate-500 shrink-0">Etiqueta:</span>
                                        <input type="text" name="amenities[{{ $key }}][value]" value="{{ $value }}" placeholder="Ej: {{ $item['default'] }}"
                                               class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-lg px-2 py-0.5 text-[10px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-semibold shadow-inner">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
