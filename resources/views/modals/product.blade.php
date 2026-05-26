<template x-teleport="body">
    <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <!-- Backdrop -->
        <div x-show="showModal" x-transition.opacity.duration.300ms
            class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeModal()"></div>

        <!-- Contenedor del Modal -->
        <form id="productForm" @submit.prevent="submitForm($data)" x-show="showModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative ui-card rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col transition-colors duration-300 max-h-[90vh]">

            <!-- Encabezado (Header Sticky con color primario) -->
            <div
                class="px-6 py-5 border-b border-black/10 dark:border-white/10 flex items-center justify-between sticky top-0 z-10 bg-primary text-white transition-colors duration-300 shadow-md">
                <div>
                    <span class="text-[9px] uppercase font-extrabold tracking-widest text-white/70"
                        x-text="isEdit ? 'Editar Registro' : 'Nuevo Registro'">Nuevo Registro</span>
                    <h3 class="text-base md:text-lg font-black text-white mt-0.5"
                        x-text="isEdit ? 'Modificar Producto' : 'Registrar Producto'">Registrar Producto</h3>
                </div>
                <button type="button" @click="closeModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-all duration-200">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Formulario (Scrollable Body) -->
            <div class="p-6 space-y-4 overflow-y-auto flex-grow">
                <!-- Nombre y Categoría en Fila -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name"
                            class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Nombre
                            del Producto</label>
                        <input type="text" id="name" x-model="productName"
                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition"
                            placeholder="Ej: Arreglo Globos Premium">
                        <p x-show="errors.name" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.name">
                        </p>
                    </div>
                    <div>
                        <label for="category_id"
                            class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Categoría</label>
                        <select id="category_id" x-model="productCategoryId"
                            class="select2-enable w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                            <option value="">Selecciona Categoría</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <p x-show="errors.category_id" class="text-[10px] text-rose-500 font-bold mt-1"
                            x-text="errors.category_id"></p>
                    </div>
                </div>

                <!-- SEO: Título y Descripción -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="seo_title"
                            class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Título
                            SEO</label>
                        <input type="text" id="seo_title" x-model="productSeoTitle"
                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition"
                            placeholder="Ej: Compra Arreglo Globos Premium">
                        <p x-show="errors.seo_title" class="text-[10px] text-rose-500 font-bold mt-1"
                            x-text="errors.seo_title"></p>
                    </div>
                    <div>
                        <label for="seo_description"
                            class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Descripción
                            SEO</label>
                        <input type="text" id="seo_description" x-model="productSeoDescription"
                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition"
                            placeholder="Ej: Globos personalizados para toda ocasión. Envíos rápidos.">
                        <p x-show="errors.seo_description" class="text-[10px] text-rose-500 font-bold mt-1"
                            x-text="errors.seo_description"></p>
                    </div>
                </div>

                <!-- Precio y Disponibilidad -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="price"
                            class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Precio
                            ($)</label>
                        <input type="number" step="0.01" id="price" x-model="productPrice"
                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition"
                            placeholder="Ej: 25.00">
                        <p x-show="errors.price" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.price">
                        </p>
                    </div>
                    <div>
                        <label for="is_available"
                            class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Disponibilidad</label>
                        <select id="is_available" x-model="productIsAvailable"
                            class="select2-enable w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                            <option value="1">Disponible / Activo</option>
                            <option value="0">Agotado / Inactivo</option>
                        </select>
                    </div>
                </div>

                <!-- Descripción -->
                <div>
                    <label for="description"
                        class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Descripción
                        o Detalles</label>
                    <textarea id="description" x-model="productDescription" rows="3"
                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition resize-none"
                        placeholder="Ingresa los detalles del producto..."></textarea>
                    <p x-show="errors.description" class="text-[10px] text-rose-500 font-bold mt-1"
                        x-text="errors.description"></p>
                </div>

                <!-- Tiempo de Preparación -->
                <div>
                    <label for="preparation_time"
                        class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Tiempo
                        Estimado de Preparación</label>
                    <input type="text" id="preparation_time" x-model="productPreparationTime"
                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition"
                        placeholder="Ej: 20-30 min">
                    <p class="text-[9px] text-slate-400 mt-1">Tiempo estimado para preparar este producto (opcional)
                    </p>
                    <p x-show="errors.preparation_time" class="text-[10px] text-rose-500 font-bold mt-1"
                        x-text="errors.preparation_time"></p>
                </div>

                <!-- CONFIGURACIÓN DE CARACTERÍSTICAS DINÁMICAS (SaaS Premium Style) -->
                <div class="border-t border-b border-slate-100 dark:border-slate-800/80 py-4 space-y-4">
                    <div>
                        <span
                            class="block text-[10px] font-black text-primary uppercase tracking-widest mb-2">Habilitar
                            Características Adicionales</span>
                        <div class="flex flex-wrap gap-2">
                            <!-- Botón Medidas -->
                            <button type="button" @click="enableMedidas = !enableMedidas"
                                :class="enableMedidas ?
                                    'bg-primary/10 text-primary border-primary/20 dark:bg-primary/20 dark:text-primary-light' :
                                    'bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-750 text-slate-500'"
                                class="px-3.5 py-2 rounded-xl border text-[10px] font-black uppercase tracking-wider transition flex items-center gap-1.5 cursor-pointer">
                                <i class="fas fa-weight-hanging"></i> Medidas
                            </button>
                            <!-- Botón Sabores -->
                            <button type="button" @click="enableSabores = !enableSabores"
                                :class="enableSabores ?
                                    'bg-primary/10 text-primary border-primary/20 dark:bg-primary/20 dark:text-primary-light' :
                                    'bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-750 text-slate-500'"
                                class="px-3.5 py-2 rounded-xl border text-[10px] font-black uppercase tracking-wider transition flex items-center gap-1.5 cursor-pointer">
                                <i class="fas fa-cookie-bite"></i> Sabores
                            </button>
                            <!-- Botón Colores -->
                            <button type="button" @click="enableColores = !enableColores"
                                :class="enableColores ?
                                    'bg-primary/10 text-primary border-primary/20 dark:bg-primary/20 dark:text-primary-light' :
                                    'bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-750 text-slate-500'"
                                class="px-3.5 py-2 rounded-xl border text-[10px] font-black uppercase tracking-wider transition flex items-center gap-1.5 cursor-pointer">
                                <i class="fas fa-palette"></i> Colores
                            </button>
                            <!-- Botón Tamaños -->
                            <button type="button" @click="enableTamanos = !enableTamanos"
                                :class="enableTamanos ?
                                    'bg-primary/10 text-primary border-primary/20 dark:bg-primary/20 dark:text-primary-light' :
                                    'bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-750 text-slate-500'"
                                class="px-3.5 py-2 rounded-xl border text-[10px] font-black uppercase tracking-wider transition flex items-center gap-1.5 cursor-pointer">
                                <i class="fas fa-compress-alt"></i> Tamaños
                            </button>
                            <!-- Botón Otros -->
                            <button type="button" @click="enableOtros = !enableOtros"
                                :class="enableOtros ?
                                    'bg-primary/10 text-primary border-primary/20 dark:bg-primary/20 dark:text-primary-light' :
                                    'bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-750 text-slate-500'"
                                class="px-3.5 py-2 rounded-xl border text-[10px] font-black uppercase tracking-wider transition flex items-center gap-1.5 cursor-pointer">
                                <i class="fas fa-cog"></i> Otros
                            </button>
                        </div>
                    </div>

                    <!-- Panel Medidas -->
                    <div x-show="enableMedidas" x-cloak x-transition
                        class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 space-y-2">
                        <label class="block text-[9px] font-extrabold text-primary uppercase tracking-widest">Unidades
                            de Medida</label>
                        <select id="selectedMedidaPreset" x-model="selectedMedidaPreset"
                            @change="handleMedidaSelect()"
                            class="select2-enable w-full ui-field border text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none">
                            <option value="">-- Selecciona Medida --</option>
                            <option value="Unidad">Unidad</option>
                            <option value="1 Kg">1 Kg</option>
                            <option value="500 g">500 g</option>
                            <option value="250 g">250 g</option>
                            <option value="1 Litro">1 Litro</option>
                            <option value="500 ml">500 ml</option>
                            <option value="Docena">Docena</option>
                            <option value="Pack">Pack</option>
                            <option value="custom">+ Agregar personalizada...</option>
                        </select>
                        <div x-show="showCustomMedida" x-cloak class="flex gap-2 mt-2">
                            <input type="text" x-model="tempMedida" @keydown.enter.prevent="addMedida()"
                                class="flex-grow ui-field border text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none"
                                placeholder="Medida personalizada...">
                            <button type="button" @click="addMedida()"
                                class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-655 text-slate-750 dark:text-slate-200 px-4 rounded-xl text-xs font-bold transition cursor-pointer"><i
                                    class="fas fa-plus"></i></button>
                        </div>
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            <template x-for="(medida, index) in productFeatures.medidas" :key="index">
                                <span
                                    class="ui-field border text-slate-700 dark:text-slate-300 text-[10px] font-bold pl-3 pr-2 py-1 rounded-xl flex items-center gap-1.5 shadow-sm">
                                    <span x-text="medida"></span>
                                    <button type="button" @click="removeMedida(index)"
                                        class="text-slate-400 hover:text-rose-500 text-xs cursor-pointer"><i
                                            class="fas fa-times"></i></button>
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- Panel Sabores -->
                    <div x-show="enableSabores" x-cloak x-transition
                        class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 space-y-2">
                        <label class="block text-[9px] font-extrabold text-primary uppercase tracking-widest">Sabores
                            Disponibles</label>
                        <select id="selectedSaborPreset" x-model="selectedSaborPreset" @change="handleSaborSelect()"
                            class="select2-enable w-full ui-field border text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none">
                            <option value="">-- Selecciona Sabor --</option>
                            <option value="Chocolate">Chocolate</option>
                            <option value="Vainilla">Vainilla</option>
                            <option value="Fresa">Fresa</option>
                            <option value="Limón">Limón</option>
                            <option value="Menta">Menta</option>
                            <option value="Dulce de Leche">Dulce de Leche</option>
                            <option value="Nutella">Nutella</option>
                            <option value="Oreo">Oreo</option>
                            <option value="custom">+ Agregar personalizado...</option>
                        </select>
                        <div x-show="showCustomSabor" x-cloak class="flex gap-2 mt-2">
                            <input type="text" x-model="tempSabor" @keydown.enter.prevent="addSabor()"
                                class="flex-grow ui-field border text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none"
                                placeholder="Sabor personalizado...">
                            <button type="button" @click="addSabor()"
                                class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-655 text-slate-750 dark:text-slate-200 px-4 rounded-xl text-xs font-bold transition cursor-pointer"><i
                                    class="fas fa-plus"></i></button>
                        </div>
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            <template x-for="(sabor, index) in productFeatures.sabores" :key="index">
                                <span
                                    class="ui-field border text-slate-700 dark:text-slate-300 text-[10px] font-bold pl-3 pr-2 py-1 rounded-xl flex items-center gap-1.5 shadow-sm">
                                    <span x-text="sabor"></span>
                                    <button type="button" @click="removeSabor(index)"
                                        class="text-slate-400 hover:text-rose-500 text-xs cursor-pointer"><i
                                            class="fas fa-times"></i></button>
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- Panel Colores -->
                    <div x-show="enableColores" x-cloak x-transition
                        class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 space-y-2">
                        <label class="block text-[9px] font-extrabold text-primary uppercase tracking-widest">Gama de
                            Colores</label>
                        <select id="selectedColorPreset" x-model="selectedColorPreset" @change="handleColorSelect()"
                            class="select2-enable w-full ui-field border text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none">
                            <option value="">-- Selecciona Color --</option>
                            <option value="Negro|#000000">Negro</option>
                            <option value="Blanco|#FFFFFF">Blanco</option>
                            <option value="Rojo|#EF4444">Rojo</option>
                            <option value="Azul|#3B82F6">Azul</option>
                            <option value="Verde|#10B981">Verde</option>
                            <option value="Rosa|#EC4899">Rosa</option>
                            <option value="Amarillo|#F59E0B">Amarillo</option>
                            <option value="custom">+ Personalizado...</option>
                        </select>
                        <div x-show="showCustomColor" x-cloak class="flex gap-2 items-center mt-2">
                            <input type="text" x-model="tempColorName"
                                class="flex-grow ui-field border text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none"
                                placeholder="Nombre (ej: Rojo)...">
                            <div
                                class="w-10 h-10 shrink-0 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden relative">
                                <input type="color" x-model="tempColorHex"
                                    class="absolute inset-0 w-full h-full p-0 border-none cursor-pointer scale-150">
                            </div>
                            <button type="button" @click="addColor()"
                                class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-655 text-slate-750 dark:text-slate-200 px-4 rounded-xl text-xs font-bold transition h-10 cursor-pointer"><i
                                    class="fas fa-plus"></i></button>
                        </div>
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            <template x-for="(color, index) in productFeatures.colores" :key="index">
                                <span
                                    class="ui-field border text-slate-700 dark:text-slate-300 text-[10px] font-bold pl-3 pr-2 py-1 rounded-xl flex items-center gap-2 shadow-sm">
                                    <span class="w-2.5 h-2.5 rounded-full inline-block border border-black/10"
                                        :style="'background-color: ' + color.hex"></span>
                                    <span x-text="color.nombre"></span>
                                    <button type="button" @click="removeColor(index)"
                                        class="text-slate-400 hover:text-rose-500 text-xs cursor-pointer"><i
                                            class="fas fa-times"></i></button>
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- Panel Tamaños -->
                    <div x-show="enableTamanos" x-cloak x-transition
                        class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 space-y-2">
                        <label class="block text-[9px] font-extrabold text-primary uppercase tracking-widest">Tamaños /
                            Tallas</label>
                        <select id="selectedTamanoPreset" x-model="selectedTamanoPreset"
                            @change="handleTamanoSelect()"
                            class="select2-enable w-full ui-field border text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none">
                            <option value="">-- Selecciona Tamaño --</option>
                            <option value="Chico">Chico</option>
                            <option value="Mediano">Mediano</option>
                            <option value="Grande">Grande</option>
                            <option value="Mini">Mini</option>
                            <option value="Estándar">Estándar</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                            <option value="custom">+ Agregar personalizado...</option>
                        </select>
                        <div x-show="showCustomTamano" x-cloak class="flex gap-2 mt-2">
                            <input type="text" x-model="tempTamano" @keydown.enter.prevent="addTamano()"
                                class="flex-grow ui-field border text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none"
                                placeholder="Tamaño personalizado...">
                            <button type="button" @click="addTamano()"
                                class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-655 text-slate-750 dark:text-slate-200 px-4 rounded-xl text-xs font-bold transition cursor-pointer"><i
                                    class="fas fa-plus"></i></button>
                        </div>
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            <template x-for="(tamano, index) in productFeatures.tamanos" :key="index">
                                <span
                                    class="ui-field border text-slate-700 dark:text-slate-300 text-[10px] font-bold pl-3 pr-2 py-1 rounded-xl flex items-center gap-1.5 shadow-sm">
                                    <span x-text="tamano"></span>
                                    <button type="button" @click="removeTamano(index)"
                                        class="text-slate-400 hover:text-rose-500 text-xs cursor-pointer"><i
                                            class="fas fa-times"></i></button>
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- Panel Otros -->
                    <div x-show="enableOtros" x-cloak x-transition
                        class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 space-y-3">
                        <label class="block text-[9px] font-extrabold text-primary uppercase tracking-widest">Otras
                            Características Personalizadas</label>

                        <!-- Dropdown de presets de Nombre de Característica -->
                        <div class="space-y-1">
                            <span class="block text-[9px] font-bold text-primary/80 uppercase tracking-wider">1. Tipo
                                de Característica</span>
                            <select id="selectedOtroPreset" x-model="selectedOtroPreset"
                                @change="handleOtroPresetSelect()"
                                class="select2-enable w-full ui-field border text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none">
                                <option value="">-- Selecciona Tipo --</option>
                                <option value="Adicionales">Adicionales</option>
                                <option value="Salsas">Salsas</option>
                                <option value="Tipo de Pan">Tipo de Pan</option>
                                <option value="Término de Carne">Término de Carne</option>
                                <option value="Ingredientes Extra">Ingredientes Extra</option>
                                <option value="custom">+ Nombre Personalizado...</option>
                            </select>
                        </div>

                        <!-- Input del nombre de la característica (ej: Tipo de Pan, Salsa, etc.) si es custom -->
                        <div x-show="showCustomOtro || tempOtroName" x-cloak class="space-y-1 pt-1">
                            <span class="block text-[9px] font-bold text-primary/80 uppercase tracking-wider">Nombre
                                Seleccionado</span>
                            <input type="text" x-model="tempOtroName"
                                class="w-full ui-field border text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none"
                                placeholder="Ej: Tipo de Pan, Adicionales...">
                        </div>

                        <!-- Creador de valores con sugerencias de presets y botones táctiles móviles -->
                        <template x-if="tempOtroName.trim()">
                            <div class="space-y-2 pt-1 border-t border-slate-200/40 dark:border-slate-800/40">
                                <!-- Sugerencias rápidas (Chips dinámicos en base al nombre de la característica) -->
                                <div class="space-y-1" x-show="getOtroValuePresets().length > 0">
                                    <span
                                        class="block text-[9px] font-black text-primary/80 uppercase tracking-wider">Sugerencias
                                        rápidas (Toca para agregar):</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        <template x-for="pVal in getOtroValuePresets()">
                                            <button type="button" @click="addOtroValuePreset(pVal)"
                                                class="bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-750 text-slate-700 dark:text-slate-300 text-[10px] font-bold px-2.5 py-1 rounded-xl border border-slate-200 dark:border-slate-700/80 shadow-sm transition active:scale-95 cursor-pointer">
                                                + <span x-text="pVal"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <span
                                        class="block text-[9px] font-bold text-primary/80 uppercase tracking-wider">2.
                                        Opciones / Valores de la Característica</span>
                                    <div class="flex gap-2">
                                        <input type="text" x-model="tempOtroSingleValue"
                                            @keydown.enter.prevent="addOtroValue()"
                                            class="flex-grow ui-field border text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none"
                                            placeholder="Ej: Integral, Brioche, Sin Queso...">
                                        <button type="button" @click="addOtroValue()"
                                            class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-655 text-slate-750 dark:text-slate-200 px-4 rounded-xl text-xs font-bold transition flex items-center justify-center cursor-pointer">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Chips de valores que se están configurando en caliente -->
                                <div class="flex flex-wrap gap-1.5 pt-1" x-show="tempOtroValuesList.length > 0">
                                    <template x-for="(val, vIdx) in tempOtroValuesList" :key="vIdx">
                                        <span
                                            class="bg-primary/5 dark:bg-primary/20 border border-primary/10 text-primary dark:text-primary-light text-[10px] font-bold pl-3 pr-2 py-1 rounded-xl flex items-center gap-1.5 shadow-sm">
                                            <span x-text="val"></span>
                                            <button type="button" @click="removeOtroValue(vIdx)"
                                                class="text-primary hover:text-rose-500 text-xs cursor-pointer"><i
                                                    class="fas fa-times"></i></button>
                                        </span>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- Botón principal para consolidar la característica -->
                        <button type="button" @click="addOtro()"
                            :disabled="!tempOtroName.trim() || tempOtroValuesList.length === 0"
                            :class="(!tempOtroName.trim() || tempOtroValuesList.length === 0) ?
                            'opacity-50 cursor-not-allowed bg-slate-200 dark:bg-slate-700 text-slate-400' :
                            'bg-primary text-white hover:bg-primary/90 shadow-sm'"
                            class="w-full py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 cursor-pointer mt-2">
                            <i class="fas fa-check"></i> Registrar Característica
                        </button>

                        <!-- Listado de Características ya guardadas para este producto -->
                        <div class="flex flex-col gap-2 pt-2 border-t border-slate-100 dark:border-slate-800/80"
                            x-show="productFeatures.otros.length > 0">
                            <span
                                class="block text-[9px] font-black text-primary uppercase tracking-widest mb-1">Características
                                Registradas:</span>
                            <template x-for="(otro, index) in productFeatures.otros" :key="index">
                                <div
                                    class="ui-field border p-3 rounded-xl flex items-center justify-between text-xs shadow-sm">
                                    <div>
                                        <span class="font-extrabold text-slate-750 dark:text-slate-355"
                                            x-text="otro.nombre + ': '"></span>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            <template x-for="v in otro.valores">
                                                <span
                                                    class="bg-slate-50 dark:bg-slate-750 text-slate-600 dark:text-slate-300 text-[9px] font-bold px-2 py-0.5 rounded border border-slate-150 dark:border-slate-700"
                                                    x-text="v"></span>
                                            </template>
                                        </div>
                                    </div>
                                    <button type="button" @click="removeOtro(index)"
                                        class="text-slate-400 hover:text-rose-500 transition cursor-pointer self-start p-1"><i
                                            class="fas fa-trash-alt"></i></button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Imagen del Producto -->
                <div>
                    <label class="block text-[10px] font-black text-primary uppercase tracking-widest mb-2">Imagen del
                        Producto</label>
                    <div class="flex items-center gap-4">
                        <!-- Preview -->
                        <div
                            class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-800 border border-slate-200/50 dark:border-slate-700/80 overflow-hidden flex items-center justify-center shrink-0">
                            <template x-if="productImagePreview">
                                <img :src="productImagePreview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!productImagePreview">
                                <svg width="20" height="20" class="text-slate-400" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2">
                                    </rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </template>
                        </div>
                        <!-- Upload input -->
                        <div class="flex-grow">
                            <input type="file" id="image" accept="image/*" @change="handleImageChange"
                                class="hidden">
                            <button type="button" onclick="document.getElementById('image').click()"
                                class="bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-slate-700 dark:text-slate-300 text-xs font-bold px-4 py-2.5 rounded-xl transition cursor-pointer flex items-center gap-2">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                                Cargar Imagen
                            </button>
                            <span class="text-[9px] text-slate-400 block mt-1">Formatos sugeridos: JPG, PNG. Máximo
                                2MB.</span>
                        </div>
                    </div>
                    <p x-show="errors.image" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.image">
                    </p>
                </div>
            </div>

            <!-- Botones de Acción (Footer Sticky con color primario) -->
            <div
                class="px-6 py-4 bg-primary flex justify-end gap-3 sticky bottom-0 z-10 shadow-[0_-4px_12px_rgba(0,0,0,0.08)] border-t border-black/10 transition-colors">
                <button type="button" @click="closeModal()"
                    class="bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs px-5 py-3 rounded-xl transition shadow-sm active:scale-95">
                    Cancelar
                </button>
                <button type="submit"
                    class="bg-white hover:bg-white/95 text-primary font-black text-xs px-6 py-3 rounded-xl transition shadow-md active:scale-95 flex items-center gap-2">
                    <span x-text="isEdit ? 'Guardar Cambios' : 'Crear Producto'">Crear Producto</span>
                </button>
            </div>
        </form>
    </div>
</template>
