                    <!-- Horario de Trabajo -->
                    @php
                        $currentHours = old('work_hours', $shop->work_hours);
                        // Decodificar si es string JSON
                        if (is_string($currentHours)) {
                            $decoded = json_decode($currentHours, true);
                            if ($decoded !== null) {
                                $currentHours = $decoded;
                            }
                        }
                        $defaultSchedule = [
                            'Lunes' => ['closed' => false, 'open' => '08:00', 'close' => '18:00'],
                            'Martes' => ['closed' => false, 'open' => '08:00', 'close' => '18:00'],
                            'Miércoles' => ['closed' => false, 'open' => '08:00', 'close' => '18:00'],
                            'Jueves' => ['closed' => false, 'open' => '08:00', 'close' => '18:00'],
                            'Viernes' => ['closed' => false, 'open' => '08:00', 'close' => '18:00'],
                            'Sábado' => ['closed' => false, 'open' => '08:00', 'close' => '18:00'],
                            'Domingo' => ['closed' => true, 'open' => '08:00', 'close' => '18:00'],
                        ];
                        $isCustom = is_array($currentHours) && isset($currentHours['type']) && $currentHours['type'] === 'custom';
                        $simpleText = is_array($currentHours) && isset($currentHours['type']) && $currentHours['type'] === 'simple'
                                        ? $currentHours['text']
                                        : (!is_array($currentHours) ? $currentHours : '');
                        $scheduleData = $isCustom && isset($currentHours['schedule']) ? $currentHours['schedule'] : $defaultSchedule;
                    @endphp

                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Horario de Trabajo</label>
                            <button type="button"
                                    onclick="toggleWorkHoursType()"
                                    class="text-[8px] font-bold px-1.5 py-0.5 rounded transition-all border bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700">
                                <span id="work-hours-toggle-text">Avanzado</span>
                            </button>
                        </div>

                        <!-- Input Simple -->
                        <div id="work-hours-simple" style="display: {{ $isCustom ? 'none' : 'block' }};">
                            <input type="text" name="work_hours_simple"
                                   value="{{ $simpleText }}"
                                   class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-medium"
                                   placeholder="Ej: Lun - Sab, 8am a 6pm">
                        </div>

                        <!-- Constructor Custom -->
                        <div id="work-hours-custom" style="display: {{ $isCustom ? 'block' : 'none' }};"
                             class="bg-slate-50 dark:bg-slate-950 rounded-xl p-2.5 shadow-inner border border-slate-200 dark:border-slate-850 mt-1 transition-colors max-h-[140px] overflow-y-auto custom-scrollbar">
                            <div class="space-y-1.5">
                                @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $day)
                                    @php
                                        $daySchedule = $scheduleData[$day] ?? ['closed' => false, 'open' => '08:00', 'close' => '18:00'];
                                    @endphp
                                    <div class="flex items-center gap-1.5 pb-1.5 border-b border-slate-200 dark:border-slate-800/80 last:border-0 last:pb-0">
                                        <div class="w-14 shrink-0">
                                            <span class="text-[10px] font-bold text-slate-800 dark:text-slate-250">{{ $day }}</span>
                                        </div>
                                        <label class="flex items-center gap-1 cursor-pointer shrink-0">
                                            <input type="checkbox" name="schedule[{{ $day }}][closed]" value="1" {{ $daySchedule['closed'] ? 'checked' : '' }} class="w-3 h-3 rounded border-slate-300 text-primary focus:ring-primary bg-white dark:bg-slate-800 cursor-pointer">
                                            <span class="text-[9px] font-semibold text-slate-450 dark:text-slate-500">Cerrado</span>
                                        </label>
                                        <div class="flex items-center gap-1 flex-grow {{ $daySchedule['closed'] ? 'opacity-30 pointer-events-none' : '' }}">
                                            <input type="time" name="schedule[{{ $day }}][open]" value="{{ $daySchedule['open'] }}" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 rounded px-1 py-0.5 text-[9px] font-semibold text-slate-700 dark:text-slate-300 focus:outline-none">
                                            <span class="text-slate-400 text-[9px] font-bold">-</span>
                                            <input type="time" name="schedule[{{ $day }}][close]" value="{{ $daySchedule['close'] }}" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-850 rounded px-1 py-0.5 text-[9px] font-semibold text-slate-700 dark:text-slate-300 focus:outline-none">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" name="work_hours_type" id="work_hours_type" value="{{ $isCustom ? 'custom' : 'simple' }}">
                    </div>

                    <!-- Métodos de Pago -->
                    <div class="space-y-1">
                        @php
                            $paymentMethods = $shop->payment_methods ? json_decode($shop->payment_methods, true) : [];
                            if (empty($paymentMethods)) {
                                $paymentMethods = [
                                    'Efectivo' => ['active' => true, 'details' => ''],
                                    'Pago Móvil' => ['active' => true, 'details' => '']
                                ];
                            }
                            $availableMethods = [
                                'Transferencia' => ['color' => 'bg-slate-600 text-white border-slate-600 shadow-sm', 'placeholder' => 'Banco, Número de Cuenta, Titular, RIF...'],
                                'Pago Móvil' => ['color' => 'bg-teal-500 text-white border-teal-500 shadow-sm', 'placeholder' => 'Banco, Teléfono, Cédula...'],
                                'Efectivo' => ['color' => 'bg-emerald-600 text-white border-emerald-600 shadow-sm', 'placeholder' => 'Detalles (ej: Traer sencillo, Se acepta cambio...)'],
                                'Zelle' => ['color' => 'bg-purple-600 text-white border-purple-600 shadow-sm', 'placeholder' => 'Correo de Zelle, Nombre...'],
                                'Binance' => ['color' => 'bg-yellow-500 text-white border-yellow-500 shadow-sm', 'placeholder' => 'Pay ID, Correo, USDT...'],
                                'PayPal' => ['color' => 'bg-blue-600 text-white border-blue-600 shadow-sm', 'placeholder' => 'Correo de cuenta...'],
                                'Punto de Venta' => ['color' => 'bg-indigo-500 text-white border-indigo-500 shadow-sm', 'placeholder' => 'Detalles (ej: Pago directo al retirar/recibir...)']
                            ];
                        @endphp
                        <label class="text-[10px] font-bold text-slate-700 dark:text-slate-300 block mb-0.5">Métodos de Pago</label>
                        <div class="flex flex-wrap gap-1">
                            @foreach($availableMethods as $name => $config)
                                @php
                                    $isActive = isset($paymentMethods[$name]) && $paymentMethods[$name]['active'];
                                @endphp
                                <button type="button"
                                        onclick="togglePaymentMethod('{{ $name }}')"
                                        class="{{ $isActive ? $config['color'] : 'bg-white dark:bg-slate-900 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-750 hover:bg-slate-50 dark:hover:bg-slate-800 shadow-sm' }} px-2 py-0.5 rounded-lg border text-[9px] font-bold transition-all duration-300 select-none flex items-center gap-1 focus:outline-none">
                                    @if($isActive)
                                        <svg class="w-2.5 h-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    @endif
                                    <span>{{ $name }}</span>
                                </button>
                            @endforeach
                        </div>

                        <!-- Detalle de Datos de Pago -->
                        <div class="mt-3.5 space-y-2" id="payment-details">
                            <label class="text-[10px] font-black text-primary uppercase tracking-widest block">Instrucciones / Datos de Pago</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-[180px] overflow-y-auto custom-scrollbar p-0.5">
                                @foreach($availableMethods as $name => $config)
                                    @php
                                        $isActive = isset($paymentMethods[$name]) && $paymentMethods[$name]['active'];
                                        $details = isset($paymentMethods[$name]) ? ($paymentMethods[$name]['details'] ?? '') : '';
                                    @endphp
                                    <div id="payment-{{ $name }}" class="{{ $isActive ? '' : 'hidden' }} bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-2.5 rounded-xl space-y-1 shadow-sm transition hover:shadow-md">
                                        <span class="text-[10px] font-bold text-slate-700 dark:text-slate-200 block">{{ $name }}</span>
                                        <textarea
                                            name="payment_details[{{ $name }}]"
                                            placeholder="{{ $config['placeholder'] }}"
                                            class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-850 rounded-lg px-2 py-1 text-[10px] text-slate-800 dark:text-slate-200 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-semibold"
                                            rows="2"
                                        >{{ $details }}</textarea>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <input type="hidden" name="payment_methods" id="payment_methods_json" value="{!! json_encode($paymentMethods) !!}">
                    </div>
