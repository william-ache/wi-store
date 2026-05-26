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
                                        class="{{ $isActive ? $config['color'] : 'ui-surface text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-750 hover:bg-slate-50 dark:hover:bg-slate-800 shadow-sm' }} px-2 py-0.5 rounded-lg border text-[9px] font-bold transition-all duration-300 select-none flex items-center gap-1 focus:outline-none">
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
                                    <div id="payment-{{ $name }}" class="{{ $isActive ? '' : 'hidden' }} ui-card border p-2.5 rounded-xl space-y-1 shadow-sm transition hover:shadow-md">
                                        <span class="text-[10px] font-bold text-slate-700 dark:text-slate-200 block">{{ $name }}</span>
                                        <textarea
                                            name="payment_details[{{ $name }}]"
                                            placeholder="{{ $config['placeholder'] }}"
                                            class="w-full ui-inset border border-slate-200 dark:border-slate-850 rounded-lg px-2 py-1 text-[10px] text-slate-800 dark:text-slate-200 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all font-semibold"
                                            rows="2"
                                        >{{ $details }}</textarea>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <input type="hidden" name="payment_methods" id="payment_methods_json" value="{!! json_encode($paymentMethods) !!}">
                    </div>

                    @include('partials.settings.comercio.cashea')
                    @include('partials.settings.comercio.krece')
