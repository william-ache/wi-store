                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                        <!-- Nombre de la Empresa -->
                        <div class="space-y-0.5">
                            <label for="name" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Nombre de la Empresa</label>
                            <input type="text" id="name" name="name" 
                                   class="w-full ui-field border rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                   value="{{ old('name', $shop->name) }}" required>
                        </div>

                        <!-- Categoría de la Tienda -->
                        <div class="space-y-0.5">
                            <label for="shop_category" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Categoría de la Tienda</label>
                            <select id="shop_category" name="shop_category" 
                                    class="w-full ui-field border rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold"
                                    onchange="updateShopCategoryIcon(this.value)">
                                <option value="">Selecciona una categoría</option>
                                <option value="gastronomia" {{ old('shop_category', $shop->shop_category) == 'gastronomia' ? 'selected' : '' }}>🍽️ Gastronomía</option>
                                <option value="moda_estilo" {{ old('shop_category', $shop->shop_category) == 'moda_estilo' ? 'selected' : '' }}>👗 Moda y Estilo</option>
                                <option value="detalles_regalos" {{ old('shop_category', $shop->shop_category) == 'detalles_regalos' ? 'selected' : '' }}>🎁 Detalles y Regalos</option>
                                <option value="servicios" {{ old('shop_category', $shop->shop_category) == 'servicios' ? 'selected' : '' }}>🔧 Servicios</option>
                                <option value="otros" {{ old('shop_category', $shop->shop_category) == 'otros' ? 'selected' : '' }}>📦 Otros</option>
                            </select>
                            <input type="hidden" id="shop_category_icon" name="shop_category_icon" value="{{ old('shop_category_icon', $shop->shop_category_icon) }}">
                        </div>

                        <!-- WhatsApp de Pedidos -->
                        <div class="space-y-0.5 col-span-1 sm:col-span-2">
                            <label for="whatsapp_number" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">WhatsApp de Pedidos (Soporta Múltiples Números)</label>
                            <input type="text" id="whatsapp_number" name="whatsapp_number" 
                                   class="w-full ui-field border rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                   value="{{ old('whatsapp_number', $shop->whatsapp_number) }}" required placeholder="e.g. 584120000000 o Pedidos:584121111111, Soporte:584122222222">
                            <p class="settings-help-text text-[9px] md:text-xs text-slate-450 dark:text-slate-500 font-medium leading-normal mt-0.5">
                                Si tienes un solo número, colócalo directamente (ej: <code>584120000000</code>). Para múltiples números, colócalos separados por comas y con etiquetas opcionales (ej: <code>Ventas:584121111111, Soporte:584122222222</code>).
                            </p>
                        </div>
                    </div>

                    <!-- Descripción/Eslogan -->
                    <div class="space-y-0.5">
                        <label for="description" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Descripción o Eslogan</label>
                        <textarea id="description" name="description" 
                                  class="w-full ui-field border rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-medium" 
                                  rows="2">{{ old('description', $shop->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                        <!-- Ubicación -->
                        <div class="space-y-0.5">
                            <label for="address" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Dirección Física</label>
                            <input type="text" id="address" name="address" 
                                   class="w-full ui-field border rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-medium" 
                                   value="{{ old('address', $shop->address) }}">
                        </div>

                        <!-- Google Maps -->
                        <div class="space-y-0.5">
                            <div class="flex items-center justify-between">
                                <label for="google_maps_link" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Enlace de Google Maps</label>
                                <span id="maps-resolving" class="text-[9px] text-primary font-bold flex items-center gap-1" style="display: none;">
                                    <svg class="animate-spin w-2.5 h-2.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Resolviendo...
                                </span>
                            </div>
                            <input type="text" id="google_maps_link" name="google_maps_link"
                                   class="w-full ui-field border rounded-xl px-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-medium"
                                   value="{{ old('google_maps_link', $shop->google_maps_link ?? '') }}"
                                   placeholder="https://maps.app.goo.gl/...">
                        </div>
                    </div>

                    @include('partials.settings.comercio.enlace-corto')
