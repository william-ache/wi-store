                    <div class="border-t border-slate-200 dark:border-slate-800/80 pt-3.5 mt-3.5 space-y-3">
                        <h5 class="text-[10px] font-black uppercase tracking-wider text-slate-400 dark:text-slate-500 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary/80"></span>Redes Sociales
                        </h5>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Facebook -->
                            <div class="space-y-0.5">
                                <label for="facebook" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Facebook URL</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3 text-slate-400 text-xs"><i class="fab fa-facebook-f"></i></span>
                                    <input type="text" id="facebook" name="facebook" 
                                           class="w-full ui-field border rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                           value="{{ old('facebook', $shop->facebook) }}" placeholder="https://facebook.com/pagina">
                                </div>
                            </div>
                            <!-- Instagram -->
                            <div class="space-y-0.5">
                                <label for="instagram" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Instagram URL</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3 text-slate-400 text-xs"><i class="fab fa-instagram"></i></span>
                                    <input type="text" id="instagram" name="instagram" 
                                           class="w-full ui-field border rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                           value="{{ old('instagram', $shop->instagram) }}" placeholder="https://instagram.com/usuario">
                                </div>
                            </div>
                            <!-- TikTok -->
                            <div class="space-y-0.5">
                                <label for="tiktok" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">TikTok URL</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3 text-slate-400 text-xs"><i class="fab fa-tiktok"></i></span>
                                    <input type="text" id="tiktok" name="tiktok" 
                                           class="w-full ui-field border rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                           value="{{ old('tiktok', $shop->tiktok) }}" placeholder="https://tiktok.com/@usuario">
                                </div>
                            </div>
                            <!-- X / Twitter -->
                            <div class="space-y-0.5">
                                <label for="x_twitter" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">X (Twitter) URL</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3 text-slate-400 w-4 h-4 flex items-center justify-center pointer-events-none">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                        </svg>
                                    </span>
                                    <input type="text" id="x_twitter" name="x_twitter" 
                                           class="w-full ui-field border rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                           value="{{ old('x_twitter', $shop->x_twitter) }}" placeholder="https://x.com/usuario">
                                </div>
                            </div>
                            <!-- Telegram -->
                            <div class="space-y-0.5">
                                <label for="telegram" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Telegram URL / Usuario</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3 text-slate-400 text-xs"><i class="fab fa-telegram-plane"></i></span>
                                    <input type="text" id="telegram" name="telegram" 
                                           class="w-full ui-field border rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                           value="{{ old('telegram', $shop->telegram) }}" placeholder="https://t.me/usuario o @usuario">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contacto Adicional -->
                    <div class="border-t border-slate-200 dark:border-slate-800/80 pt-3.5 mt-3.5 space-y-3">
                        <h5 class="text-[10px] font-black uppercase tracking-wider text-slate-400 dark:text-slate-500 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary/80"></span>Canales de Contacto Alternativos
                        </h5>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Teléfono para llamadas -->
                            <div class="space-y-0.5">
                                <label for="contact_phone" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Teléfono (Llamadas)</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3 text-slate-400 text-xs"><i class="fas fa-phone-alt"></i></span>
                                    <input type="text" id="contact_phone" name="contact_phone" 
                                           class="w-full ui-field border rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                           value="{{ old('contact_phone', $shop->contact_phone) }}" placeholder="e.g. +584120000000">
                                </div>
                            </div>
                            <!-- Teléfono para SMS -->
                            <div class="space-y-0.5">
                                <label for="contact_sms" class="text-[10px] font-bold text-slate-700 dark:text-slate-300">Teléfono (SMS / Mensajes)</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-3 text-slate-400 text-xs"><i class="fas fa-comment-sms"></i></span>
                                    <input type="text" id="contact_sms" name="contact_sms" 
                                           class="w-full ui-field border rounded-xl pl-8 pr-2.5 py-1.5 text-[11px] text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all shadow-sm font-semibold" 
                                           value="{{ old('contact_sms', $shop->contact_sms) }}" placeholder="e.g. +584120000000">
                                </div>
                            </div>
                        </div>
                    </div>
