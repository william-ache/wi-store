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

