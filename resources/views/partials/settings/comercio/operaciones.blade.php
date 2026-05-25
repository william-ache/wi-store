                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <!-- Tasa de Delivery por Km -->
                        <div class="space-y-0.5">
                            <label for="delivery_rate_per_km" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Delivery por Km</label>
                            <input type="number" step="0.01" id="delivery_rate_per_km" name="delivery_rate_per_km" 
                                   class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-medium" 
                                   placeholder="0.00" value="{{ old('delivery_rate_per_km', $shop->delivery_rate_per_km) }}">
                        </div>

                        <div class="space-y-0.5">
                            <label for="base_currency" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Tasa monetaria</label>
                            <div class="flex gap-2 items-center">
                                <div class="w-[45%]">
                                    <select id="base_currency" name="base_currency"
                                            class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-xl px-2 py-1.5 text-[11px] text-slate-800 dark:text-slate-250 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold select2-enable"
                                            onchange="fetchExchangeRate()">
                                        <option value="USD" {{ old('base_currency', $shop->base_currency) === 'USD' ? 'selected' : '' }}>USD</option>
                                        <option value="EUR" {{ old('base_currency', $shop->base_currency) === 'EUR' ? 'selected' : '' }}>EUR</option>
                                    </select>
                                </div>
                                <div class="relative w-[55%] flex items-center">
                                    <input type="text" name="exchange_rate" id="exchange_rate"
                                           value="{{ old('exchange_rate', $shop->exchange_rate) }}"
                                           class="w-full border border-slate-200 dark:border-slate-750 rounded-xl px-2.5 py-1.5 text-[11px] transition-all shadow-sm font-bold h-[32px] bg-slate-50 dark:bg-slate-850/80 text-slate-500 dark:text-slate-400 cursor-not-allowed select-none focus:outline-none"
                                           placeholder="Tasa oficial" readonly>
                                    <div id="exchange-loading" class="absolute right-2 top-2" style="display: none;">
                                        <svg class="animate-spin h-3.5 w-3.5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coordenadas del Local (Lat / Lng) para cálculo de distancia -->
                    <div class="bg-white dark:bg-slate-900/60 p-2.5 rounded-xl border border-slate-150 dark:border-slate-800 space-y-1.5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Geolocalización (Distancia Delivery)</span>
                            <button type="button" onclick="getGPSLocation()"
                                    class="text-[9px] font-bold text-primary hover:brightness-105 flex items-center gap-1 transition-all active:scale-95 duration-200">
                                <span id="gps-icon" class="flex items-center gap-0.5">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><path d="M12 2v4M12 18v4M4 12H2M22 12h-4"></path></svg>
                                    Usar GPS
                                </span>
                                <span id="gps-loading" x-cloak class="flex items-center gap-0.5" style="display: none;">
                                    <svg class="animate-spin w-2.5 h-2.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Localizando...
                                </span>
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-2.5">
                            <div class="flex items-center gap-1.5 bg-slate-50 dark:bg-slate-850 px-2 py-1 rounded-lg border border-slate-200 dark:border-slate-750">
                                <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase shrink-0">LAT</span>
                                <input type="text" id="latitude" name="latitude"
                                       value="{{ old('latitude', $shop->latitude ?? '') }}"
                                       class="w-full bg-transparent border-0 p-0 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-0 font-medium"
                                       placeholder="10.4806">
                            </div>
                            <div class="flex items-center gap-1.5 bg-slate-50 dark:bg-slate-850 px-2 py-1 rounded-lg border border-slate-200 dark:border-slate-750">
                                <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase shrink-0">LNG</span>
                                <input type="text" id="longitude" name="longitude"
                                       value="{{ old('longitude', $shop->longitude ?? '') }}"
                                       class="w-full bg-transparent border-0 p-0 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-0 font-medium"
                                       placeholder="-66.9036">
                            </div>
                        </div>
                    </div>

                    <!-- Opciones de Servicio -->
                    <div class="bg-white dark:bg-slate-900/60 p-3.5 rounded-xl border border-slate-150 dark:border-slate-800 space-y-2.5 shadow-sm mt-3">
                        <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider block mb-1">Opciones de Servicio Disponibles</span>
                        
                        <div class="grid grid-cols-1 gap-2">
                            <!-- Comer aquí -->
                            <div class="flex items-center justify-between p-2 rounded-xl bg-emerald-50/40 dark:bg-emerald-950/5 border border-emerald-100/50 dark:border-emerald-900/20">
                                <div class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-full bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xs">
                                        <i class="fas fa-utensils"></i>
                                    </span>
                                    <div>
                                        <div class="text-[11px] font-bold text-slate-800 dark:text-slate-200">Comer aquí</div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500">Permitir pedidos para mesa</div>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer select-none">
                                    <input type="hidden" name="has_dine_in" value="0">
                                    <input type="checkbox" name="has_dine_in" value="1" class="sr-only peer" {{ old('has_dine_in', $shop->has_dine_in) ? 'checked' : '' }}>
                                    <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                                </label>
                            </div>

                            <!-- Recoger -->
                            <div class="flex items-center justify-between p-2 rounded-xl bg-amber-50/40 dark:bg-amber-950/5 border border-amber-100/50 dark:border-amber-900/20">
                                <div class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-full bg-amber-100 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xs">
                                        <i class="fas fa-shopping-bag"></i>
                                    </span>
                                    <div>
                                        <div class="text-[11px] font-bold text-slate-800 dark:text-slate-200">Recoger</div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500">Permitir pedidos para llevar</div>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer select-none">
                                    <input type="hidden" name="has_pickup" value="0">
                                    <input type="checkbox" name="has_pickup" value="1" class="sr-only peer" {{ old('has_pickup', $shop->has_pickup) ? 'checked' : '' }}>
                                    <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-amber-500"></div>
                                </label>
                            </div>

                            <!-- Entrega a domicilio -->
                            <div class="flex items-center justify-between p-2 rounded-xl bg-blue-50/40 dark:bg-blue-950/5 border border-blue-100/50 dark:border-blue-900/20">
                                <div class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-full bg-blue-100 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs">
                                        <i class="fas fa-motorcycle"></i>
                                    </span>
                                    <div>
                                        <div class="text-[11px] font-bold text-slate-800 dark:text-slate-200">Entrega a domicilio</div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500">Permitir envíos delivery</div>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer select-none">
                                    <input type="hidden" name="has_delivery" value="0">
                                    <input type="checkbox" name="has_delivery" value="1" class="sr-only peer" {{ old('has_delivery', $shop->has_delivery) ? 'checked' : '' }}>
                                    <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-500"></div>
                                </label>
                            </div>

                            <!-- Envío gratis -->
                            <div class="flex flex-col p-2.5 rounded-xl bg-violet-50/40 dark:bg-violet-950/5 border border-violet-100/50 dark:border-violet-900/20 space-y-2.5" x-data="{ enableFreeShipping: {{ old('enable_free_shipping', $shop->enable_free_shipping ?? 0) ? 'true' : 'false' }} }">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-7 h-7 rounded-full bg-violet-100 dark:bg-violet-950/40 text-violet-600 dark:text-violet-400 flex items-center justify-center text-xs">
                                            <i class="fas fa-gift"></i>
                                        </span>
                                        <div>
                                            <div class="text-[11px] font-bold text-slate-800 dark:text-slate-200">Envío Gratis</div>
                                            <div class="text-[9px] text-slate-400 dark:text-slate-500">Ofrecer delivery gratuito a partir de un subtotal</div>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer select-none">
                                        <input type="hidden" name="enable_free_shipping" value="0">
                                        <input type="checkbox" name="enable_free_shipping" value="1" class="sr-only peer" @change="enableFreeShipping = $event.target.checked" :checked="enableFreeShipping" {{ old('enable_free_shipping', $shop->enable_free_shipping ?? 0) ? 'checked' : '' }}>
                                        <div class="relative w-[34px] h-[20px] bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-[14px] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-violet-500"></div>
                                    </label>
                                </div>
                                
                                <div x-show="enableFreeShipping" x-transition:enter="transition ease-out duration-200" x-transition:leave="transition ease-in duration-150" class="pl-9 pr-2 space-y-1">
                                    <label for="free_shipping_min_amount" class="text-[9px] font-bold text-slate-600 dark:text-slate-400 block uppercase tracking-wider">Monto Mínimo de Compra</label>
                                    <div class="relative flex items-center">
                                        <span class="absolute left-2.5 text-slate-450 text-[10px] font-black">$</span>
                                        <input type="number" step="0.01" id="free_shipping_min_amount" name="free_shipping_min_amount" 
                                               class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-750 rounded-lg pl-6 pr-2 py-1 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-violet-500 focus:ring-1 focus:ring-violet-500 transition-all font-semibold" 
                                               placeholder="10.00" value="{{ old('free_shipping_min_amount', $shop->free_shipping_min_amount) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
