@extends('layouts.admin')

@section('title', 'Gestión de Productos')
@section('subtitle', 'Tu Inventario Digital')
@section('header_title', 'Listado de Productos')

@section('content')
<div x-data="{ 
    showModal: false, 
    isEdit: false, 
    productId: null,
    productName: '',
    productCategoryId: '',
    productPrice: '',
    productDescription: '',
    productIsAvailable: 1,
    productImagePreview: null,
    productPreparationTime: '',
    errors: {},
    
    // Dynamic Product Features State
    productFeatures: {
        medidas: [],
        sabores: [],
        colores: [],
        tamanos: [],
        otros: []
    },
    tempMedida: '',
    tempSabor: '',
    tempColorName: '',
    tempColorHex: '#E60067',
    tempTamano: '',
    tempOtroName: '',
    tempOtroSingleValue: '',
    tempOtroValuesList: [],
    enableMedidas: false,
    enableSabores: false,
    enableColores: false,
    enableTamanos: false,
    enableOtros: false,

    // Preset & Conditional Select Variables
    selectedMedidaPreset: '',
    selectedSaborPreset: '',
    selectedColorPreset: '',
    selectedTamanoPreset: '',
    selectedOtroPreset: '',
    showCustomMedida: false,
    showCustomSabor: false,
    showCustomColor: false,
    showCustomTamano: false,
    showCustomOtro: false,

    init() {
        this.$watch('showModal', value => {
            if (value) {
                this.$nextTick(() => {
                    // Initialize Select2 on modal open
                    $('#category_id').select2({
                        width: '100%',
                        dropdownParent: $('#productForm')
                    });
                    
                    $('.select2-enable').not('#category_id').select2({
                        width: '100%',
                        dropdownParent: $('#productForm'),
                        minimumResultsForSearch: Infinity // Disable search for simple selectors to prevent virtual keyboard popup
                    });
                    
                    // Bind change events to Alpine.js state
                    $('#category_id').on('change', (e) => {
                        this.productCategoryId = e.target.value;
                    });
                    $('#is_available').on('change', (e) => {
                        this.productIsAvailable = parseInt(e.target.value);
                    });
                    $('#selectedMedidaPreset').on('change', (e) => {
                        const val = e.target.value;
                        if (val) {
                            this.selectedMedidaPreset = val;
                            this.handleMedidaSelect();
                            $(e.target).val('').trigger('change.select2');
                        }
                    });
                    $('#selectedSaborPreset').on('change', (e) => {
                        const val = e.target.value;
                        if (val) {
                            this.selectedSaborPreset = val;
                            this.handleSaborSelect();
                            $(e.target).val('').trigger('change.select2');
                        }
                    });
                    $('#selectedColorPreset').on('change', (e) => {
                        const val = e.target.value;
                        if (val) {
                            this.selectedColorPreset = val;
                            this.handleColorSelect();
                            $(e.target).val('').trigger('change.select2');
                        }
                    });
                    $('#selectedTamanoPreset').on('change', (e) => {
                        const val = e.target.value;
                        if (val) {
                            this.selectedTamanoPreset = val;
                            this.handleTamanoSelect();
                            $(e.target).val('').trigger('change.select2');
                        }
                    });
                    $('#selectedOtroPreset').on('change', (e) => {
                        const val = e.target.value;
                        if (val) {
                            this.selectedOtroPreset = val;
                            this.handleOtroPresetSelect();
                            $(e.target).val('').trigger('change.select2');
                        }
                    });

                    // Sync Alpine values to Select2 UI on initialization
                    $('#category_id').val(this.productCategoryId).trigger('change.select2');
                    $('#is_available').val(this.productIsAvailable).trigger('change.select2');
                    $('.select2-enable').not('#category_id, #is_available').val('').trigger('change.select2');
                });
            } else {
                // Destroy Select2 on modal close to clean up DOM and prevent memory leaks
                $('.select2-enable').select2('destroy');
            }
        });
    },

    handleMedidaSelect() {
        if (this.selectedMedidaPreset === 'custom') {
            this.showCustomMedida = true;
            this.tempMedida = '';
        } else if (this.selectedMedidaPreset) {
            this.showCustomMedida = false;
            if (!this.productFeatures.medidas.includes(this.selectedMedidaPreset)) {
                this.productFeatures.medidas.push(this.selectedMedidaPreset);
            }
            this.selectedMedidaPreset = '';
        }
    },
    handleSaborSelect() {
        if (this.selectedSaborPreset === 'custom') {
            this.showCustomSabor = true;
            this.tempSabor = '';
        } else if (this.selectedSaborPreset) {
            this.showCustomSabor = false;
            if (!this.productFeatures.sabores.includes(this.selectedSaborPreset)) {
                this.productFeatures.sabores.push(this.selectedSaborPreset);
            }
            this.selectedSaborPreset = '';
        }
    },
    handleColorSelect() {
        if (this.selectedColorPreset === 'custom') {
            this.showCustomColor = true;
            this.tempColorName = '';
            this.tempColorHex = '#E60067';
        } else if (this.selectedColorPreset) {
            this.showCustomColor = false;
            const [nombre, hex] = this.selectedColorPreset.split('|');
            const exists = this.productFeatures.colores.some(c => c.nombre.toLowerCase() === nombre.toLowerCase());
            if (!exists) {
                this.productFeatures.colores.push({ nombre, hex });
            }
            this.selectedColorPreset = '';
        }
    },
    handleTamanoSelect() {
        if (this.selectedTamanoPreset === 'custom') {
            this.showCustomTamano = true;
            this.tempTamano = '';
        } else if (this.selectedTamanoPreset) {
            this.showCustomTamano = false;
            if (!this.productFeatures.tamanos.includes(this.selectedTamanoPreset)) {
                this.productFeatures.tamanos.push(this.selectedTamanoPreset);
            }
            this.selectedTamanoPreset = '';
        }
    },
    handleOtroPresetSelect() {
        if (this.selectedOtroPreset === 'custom') {
            this.showCustomOtro = true;
            this.tempOtroName = '';
            this.tempOtroSingleValue = '';
            this.tempOtroValuesList = [];
        } else if (this.selectedOtroPreset) {
            this.showCustomOtro = false;
            this.tempOtroName = this.selectedOtroPreset;
            this.tempOtroSingleValue = '';
            this.tempOtroValuesList = [];
            this.selectedOtroPreset = '';
        }
    },
    getOtroValuePresets() {
        const name = this.tempOtroName.trim().toLowerCase();
        if (name === 'salsas') {
            return ['Ketchup', 'Mostaza', 'Mayonesa', 'BBQ', 'Salsa de Ajo', 'Salsa Golf', 'Picante'];
        }
        if (name === 'tipo de pan') {
            return ['Brioche', 'Integral', 'Blanco', 'Sin Gluten', 'Árabe', 'Focaccia'];
        }
        if (name === 'término de carne') {
            return ['Término Medio', 'Tres Cuartos', 'Bien Cocido', 'Jugoso'];
        }
        if (name === 'adicionales' || name === 'ingredientes extra') {
            return ['Queso', 'Bacon / Tocineta', 'Huevo', 'Papas Fritas', 'Aguacate / Palta', 'Cebolla Caramelizada', 'Champiñones'];
        }
        return [];
    },
    addOtroValuePreset(val) {
        if (!this.tempOtroValuesList.includes(val)) {
            this.tempOtroValuesList.push(val);
        }
    },

    addMedida() {
        if (this.tempMedida.trim()) {
            if (!this.productFeatures.medidas.includes(this.tempMedida.trim())) {
                this.productFeatures.medidas.push(this.tempMedida.trim());
            }
            this.tempMedida = '';
            this.selectedMedidaPreset = '';
            this.showCustomMedida = false;
        }
    },
    removeMedida(index) {
        this.productFeatures.medidas.splice(index, 1);
    },
    addSabor() {
        if (this.tempSabor.trim()) {
            if (!this.productFeatures.sabores.includes(this.tempSabor.trim())) {
                this.productFeatures.sabores.push(this.tempSabor.trim());
            }
            this.tempSabor = '';
            this.selectedSaborPreset = '';
            this.showCustomSabor = false;
        }
    },
    removeSabor(index) {
        this.productFeatures.sabores.splice(index, 1);
    },
    addColor() {
        if (this.tempColorName.trim()) {
            const exists = this.productFeatures.colores.some(c => c.nombre.toLowerCase() === this.tempColorName.trim().toLowerCase());
            if (!exists) {
                this.productFeatures.colores.push({
                    nombre: this.tempColorName.trim(),
                    hex: this.tempColorHex
                });
            }
            this.tempColorName = '';
            this.tempColorHex = '#E60067';
            this.selectedColorPreset = '';
            this.showCustomColor = false;
        }
    },
    removeColor(index) {
        this.productFeatures.colores.splice(index, 1);
    },
    addTamano() {
        if (this.tempTamano.trim()) {
            if (!this.productFeatures.tamanos.includes(this.tempTamano.trim())) {
                this.productFeatures.tamanos.push(this.tempTamano.trim());
            }
            this.tempTamano = '';
            this.selectedTamanoPreset = '';
            this.showCustomTamano = false;
        }
    },
    removeTamano(index) {
        this.productFeatures.tamanos.splice(index, 1);
    },
    addOtroValue() {
        if (this.tempOtroSingleValue.trim()) {
            if (!this.tempOtroValuesList.includes(this.tempOtroSingleValue.trim())) {
                this.tempOtroValuesList.push(this.tempOtroSingleValue.trim());
            }
            this.tempOtroSingleValue = '';
        }
    },
    removeOtroValue(index) {
        this.tempOtroValuesList.splice(index, 1);
    },
    addOtro() {
        if (this.tempOtroName.trim() && this.tempOtroValuesList.length > 0) {
            this.productFeatures.otros.push({
                nombre: this.tempOtroName.trim(),
                valores: [...this.tempOtroValuesList]
            });
            this.tempOtroName = '';
            this.tempOtroSingleValue = '';
            this.tempOtroValuesList = [];
            this.selectedOtroPreset = '';
            this.showCustomOtro = false;
        }
    },
    removeOtro(index) {
        this.productFeatures.otros.splice(index, 1);
    },
    
    openCreate() {
        this.isEdit = false;
        this.productId = null;
        this.productName = '';
        this.productCategoryId = '';
        this.productPrice = '';
        this.productDescription = '';
        this.productIsAvailable = 1;
        this.productImagePreview = null;
        this.productPreparationTime = '';
        document.getElementById('image').value = '';
        this.errors = {};
        
        // Reset dynamic features
        this.productFeatures = { medidas: [], sabores: [], colores: [], tamanos: [], otros: [] };
        this.tempMedida = '';
        this.tempSabor = '';
        this.tempColorName = '';
        this.tempColorHex = '#E60067';
        this.tempTamano = '';
        this.tempOtroName = '';
        this.tempOtroSingleValue = '';
        this.tempOtroValuesList = [];
        this.enableMedidas = false;
        this.enableSabores = false;
        this.enableColores = false;
        this.enableTamanos = false;
        this.enableOtros = false;

        // Reset presets and cond variables
        this.selectedMedidaPreset = '';
        this.selectedSaborPreset = '';
        this.selectedColorPreset = '';
        this.selectedTamanoPreset = '';
        this.selectedOtroPreset = '';
        this.showCustomMedida = false;
        this.showCustomSabor = false;
        this.showCustomColor = false;
        this.showCustomTamano = false;
        this.showCustomOtro = false;

        this.showModal = true;
    },
    openEdit(id, name, categoryId, price, description, isAvailable, imagePath, features, preparationTime) {
        this.isEdit = true;
        this.productId = id;
        this.productName = name;
        this.productCategoryId = categoryId;
        this.productPrice = price;
        this.productDescription = description || '';
        this.productIsAvailable = isAvailable ? 1 : 0;
        this.productImagePreview = imagePath ? (imagePath.startsWith('http') ? imagePath : '/storage/' + imagePath) : null;
        this.productPreparationTime = preparationTime || '';
        document.getElementById('image').value = '';
        this.errors = {};

        // Populate dynamic features
        let parsed = features || { medidas: [], sabores: [], colores: [], tamanos: [], otros: [] };
        this.productFeatures = {
            medidas: parsed.medidas || [],
            sabores: parsed.sabores || [],
            colores: parsed.colores || [],
            tamanos: parsed.tamanos || [],
            otros: parsed.otros || []
        };
        this.tempMedida = '';
        this.tempSabor = '';
        this.tempColorName = '';
        this.tempColorHex = '#E60067';
        this.tempTamano = '';
        this.tempOtroName = '';
        this.tempOtroSingleValue = '';
        this.tempOtroValuesList = [];
        
        this.enableMedidas = (this.productFeatures.medidas.length > 0);
        this.enableSabores = (this.productFeatures.sabores.length > 0);
        this.enableColores = (this.productFeatures.colores.length > 0);
        this.enableTamanos = (this.productFeatures.tamanos.length > 0);
        this.enableOtros = (this.productFeatures.otros.length > 0);

        // Reset presets and cond variables
        this.selectedMedidaPreset = '';
        this.selectedSaborPreset = '';
        this.selectedColorPreset = '';
        this.selectedTamanoPreset = '';
        this.selectedOtroPreset = '';
        this.showCustomMedida = false;
        this.showCustomSabor = false;
        this.showCustomColor = false;
        this.showCustomTamano = false;
        this.showCustomOtro = false;

        this.showModal = true;
    },
    closeModal() {
        this.showModal = false;
        this.errors = {};
    },
    handleImageChange(event) {
        const file = event.target.files[0];
        if (file) {
            this.productImagePreview = URL.createObjectURL(file);
        }
    }
}" id="products-page" class="space-y-6">

    <!-- Tarjeta Principal de Control (Estilo Nómina del Personal) -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] p-6 md:p-8 transition-all duration-300">
        
        <!-- Encabezado de la Sección -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h2 class="text-xl md:text-2xl font-black text-slate-800 dark:text-slate-100 tracking-tight">Listado General de Productos</h2>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Crea, edita y gestiona el inventario de artículos disponibles en tu tienda o catálogo en tiempo real.
                </p>
            </div>
            <div>
                <button @click="openCreate()" class="bg-primary hover:bg-primary/90 text-white font-extrabold text-xs px-5 py-3 rounded-xl transition shadow-md hover:shadow-lg shadow-black/5 dark:shadow-black/20 active:scale-95 flex items-center justify-center gap-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Registrar Producto
                </button>
            </div>
        </div>

        <!-- Tabla de Datos con Estilo Moderno -->
        <div class="overflow-x-auto pt-4">
            <table id="productsTable" class="w-full text-left">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre del Producto</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Disponibilidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Poblado via AJAX -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL DE CREACIÓN / EDICIÓN -->
    <template x-teleport="body">
        <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <!-- Backdrop -->
            <div x-show="showModal" x-transition.opacity.duration.300ms class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeModal()"></div>
            
            <!-- Contenedor del Modal -->
            <form id="productForm" @submit.prevent="submitForm($data)"
             x-show="showModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white dark:bg-slate-900 rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col transition-colors duration-300 max-h-[90vh]">
            
            <!-- Encabezado (Header Sticky con color primario) -->
            <div class="px-6 py-5 border-b border-black/10 dark:border-white/10 flex items-center justify-between sticky top-0 z-10 bg-primary text-white transition-colors duration-300 shadow-md">
                <div>
                    <span class="text-[9px] uppercase font-extrabold tracking-widest text-white/70" x-text="isEdit ? 'Editar Registro' : 'Nuevo Registro'">Nuevo Registro</span>
                    <h3 class="text-base md:text-lg font-black text-white mt-0.5" x-text="isEdit ? 'Modificar Producto' : 'Registrar Producto'">Registrar Producto</h3>
                </div>
                <button type="button" @click="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-all duration-200">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>

            <!-- Formulario (Scrollable Body) -->
            <div class="p-6 space-y-4 overflow-y-auto flex-grow">
                <!-- Nombre y Categoría en Fila -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Nombre del Producto</label>
                        <input type="text" id="name" x-model="productName" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: Arreglo Globos Premium">
                        <p x-show="errors.name" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.name"></p>
                    </div>
                    <div>
                        <label for="category_id" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Categoría</label>
                        <select id="category_id" x-model="productCategoryId" class="select2-enable w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                            <option value="">Selecciona Categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <p x-show="errors.category_id" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.category_id"></p>
                    </div>
                </div>

                <!-- Precio y Disponibilidad -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Precio ($)</label>
                        <input type="number" step="0.01" id="price" x-model="productPrice" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: 25.00">
                        <p x-show="errors.price" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.price"></p>
                    </div>
                    <div>
                        <label for="is_available" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Disponibilidad</label>
                        <select id="is_available" x-model="productIsAvailable" class="select2-enable w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                            <option value="1">Disponible / Activo</option>
                            <option value="0">Agotado / Inactivo</option>
                        </select>
                    </div>
                </div>

                <!-- Descripción -->
                <div>
                    <label for="description" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Descripción o Detalles</label>
                    <textarea id="description" x-model="productDescription" rows="3" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition resize-none" placeholder="Ingresa los detalles del producto..."></textarea>
                    <p x-show="errors.description" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.description"></p>
                </div>

                <!-- Tiempo de Preparación -->
                <div>
                    <label for="preparation_time" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Tiempo Estimado de Preparación</label>
                    <input type="text" id="preparation_time" x-model="productPreparationTime" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: 20-30 min">
                    <p class="text-[9px] text-slate-400 mt-1">Tiempo estimado para preparar este producto (opcional)</p>
                    <p x-show="errors.preparation_time" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.preparation_time"></p>
                </div>

                <!-- CONFIGURACIÓN DE CARACTERÍSTICAS DINÁMICAS (SaaS Premium Style) -->
                <div class="border-t border-b border-slate-100 dark:border-slate-800/80 py-4 space-y-4">
                    <div>
                        <span class="block text-[10px] font-black text-primary uppercase tracking-widest mb-2">Habilitar Características Adicionales</span>
                        <div class="flex flex-wrap gap-2">
                            <!-- Botón Medidas -->
                            <button type="button" @click="enableMedidas = !enableMedidas"
                                    :class="enableMedidas ? 'bg-primary/10 text-primary border-primary/20 dark:bg-primary/20 dark:text-primary-light' : 'bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-750 text-slate-500'"
                                    class="px-3.5 py-2 rounded-xl border text-[10px] font-black uppercase tracking-wider transition flex items-center gap-1.5 cursor-pointer">
                                <i class="fas fa-weight-hanging"></i> Medidas
                            </button>
                            <!-- Botón Sabores -->
                            <button type="button" @click="enableSabores = !enableSabores"
                                    :class="enableSabores ? 'bg-primary/10 text-primary border-primary/20 dark:bg-primary/20 dark:text-primary-light' : 'bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-750 text-slate-500'"
                                    class="px-3.5 py-2 rounded-xl border text-[10px] font-black uppercase tracking-wider transition flex items-center gap-1.5 cursor-pointer">
                                <i class="fas fa-cookie-bite"></i> Sabores
                            </button>
                            <!-- Botón Colores -->
                            <button type="button" @click="enableColores = !enableColores"
                                    :class="enableColores ? 'bg-primary/10 text-primary border-primary/20 dark:bg-primary/20 dark:text-primary-light' : 'bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-750 text-slate-500'"
                                    class="px-3.5 py-2 rounded-xl border text-[10px] font-black uppercase tracking-wider transition flex items-center gap-1.5 cursor-pointer">
                                <i class="fas fa-palette"></i> Colores
                            </button>
                            <!-- Botón Tamaños -->
                            <button type="button" @click="enableTamanos = !enableTamanos"
                                    :class="enableTamanos ? 'bg-primary/10 text-primary border-primary/20 dark:bg-primary/20 dark:text-primary-light' : 'bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-750 text-slate-500'"
                                    class="px-3.5 py-2 rounded-xl border text-[10px] font-black uppercase tracking-wider transition flex items-center gap-1.5 cursor-pointer">
                                <i class="fas fa-compress-alt"></i> Tamaños
                            </button>
                            <!-- Botón Otros -->
                            <button type="button" @click="enableOtros = !enableOtros"
                                    :class="enableOtros ? 'bg-primary/10 text-primary border-primary/20 dark:bg-primary/20 dark:text-primary-light' : 'bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-750 text-slate-500'"
                                    class="px-3.5 py-2 rounded-xl border text-[10px] font-black uppercase tracking-wider transition flex items-center gap-1.5 cursor-pointer">
                                <i class="fas fa-cog"></i> Otros
                            </button>
                        </div>
                    </div>

                    <!-- Panel Medidas -->
                    <div x-show="enableMedidas" x-cloak x-transition class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 space-y-2">
                        <label class="block text-[9px] font-extrabold text-primary uppercase tracking-widest">Unidades de Medida</label>
                        <select id="selectedMedidaPreset" x-model="selectedMedidaPreset" @change="handleMedidaSelect()" class="select2-enable w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none">
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
                            <input type="text" x-model="tempMedida" @keydown.enter.prevent="addMedida()" class="flex-grow bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none" placeholder="Medida personalizada...">
                            <button type="button" @click="addMedida()" class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-655 text-slate-750 dark:text-slate-200 px-4 rounded-xl text-xs font-bold transition cursor-pointer"><i class="fas fa-plus"></i></button>
                        </div>
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            <template x-for="(medida, index) in productFeatures.medidas" :key="index">
                                <span class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-[10px] font-bold pl-3 pr-2 py-1 rounded-xl flex items-center gap-1.5 shadow-sm">
                                    <span x-text="medida"></span>
                                    <button type="button" @click="removeMedida(index)" class="text-slate-400 hover:text-rose-500 text-xs cursor-pointer"><i class="fas fa-times"></i></button>
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- Panel Sabores -->
                    <div x-show="enableSabores" x-cloak x-transition class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 space-y-2">
                        <label class="block text-[9px] font-extrabold text-primary uppercase tracking-widest">Sabores Disponibles</label>
                        <select id="selectedSaborPreset" x-model="selectedSaborPreset" @change="handleSaborSelect()" class="select2-enable w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none">
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
                            <input type="text" x-model="tempSabor" @keydown.enter.prevent="addSabor()" class="flex-grow bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none" placeholder="Sabor personalizado...">
                            <button type="button" @click="addSabor()" class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-655 text-slate-750 dark:text-slate-200 px-4 rounded-xl text-xs font-bold transition cursor-pointer"><i class="fas fa-plus"></i></button>
                        </div>
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            <template x-for="(sabor, index) in productFeatures.sabores" :key="index">
                                <span class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-[10px] font-bold pl-3 pr-2 py-1 rounded-xl flex items-center gap-1.5 shadow-sm">
                                    <span x-text="sabor"></span>
                                    <button type="button" @click="removeSabor(index)" class="text-slate-400 hover:text-rose-500 text-xs cursor-pointer"><i class="fas fa-times"></i></button>
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- Panel Colores -->
                    <div x-show="enableColores" x-cloak x-transition class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 space-y-2">
                        <label class="block text-[9px] font-extrabold text-primary uppercase tracking-widest">Gama de Colores</label>
                        <select id="selectedColorPreset" x-model="selectedColorPreset" @change="handleColorSelect()" class="select2-enable w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none">
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
                            <input type="text" x-model="tempColorName" class="flex-grow bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none" placeholder="Nombre (ej: Rojo)...">
                            <div class="w-10 h-10 shrink-0 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden relative">
                                <input type="color" x-model="tempColorHex" class="absolute inset-0 w-full h-full p-0 border-none cursor-pointer scale-150">
                            </div>
                            <button type="button" @click="addColor()" class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-655 text-slate-750 dark:text-slate-200 px-4 rounded-xl text-xs font-bold transition h-10 cursor-pointer"><i class="fas fa-plus"></i></button>
                        </div>
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            <template x-for="(color, index) in productFeatures.colores" :key="index">
                                <span class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-[10px] font-bold pl-3 pr-2 py-1 rounded-xl flex items-center gap-2 shadow-sm">
                                    <span class="w-2.5 h-2.5 rounded-full inline-block border border-black/10" :style="'background-color: ' + color.hex"></span>
                                    <span x-text="color.nombre"></span>
                                    <button type="button" @click="removeColor(index)" class="text-slate-400 hover:text-rose-500 text-xs cursor-pointer"><i class="fas fa-times"></i></button>
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- Panel Tamaños -->
                    <div x-show="enableTamanos" x-cloak x-transition class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 space-y-2">
                        <label class="block text-[9px] font-extrabold text-primary uppercase tracking-widest">Tamaños / Tallas</label>
                        <select id="selectedTamanoPreset" x-model="selectedTamanoPreset" @change="handleTamanoSelect()" class="select2-enable w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none">
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
                            <input type="text" x-model="tempTamano" @keydown.enter.prevent="addTamano()" class="flex-grow bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none" placeholder="Tamaño personalizado...">
                            <button type="button" @click="addTamano()" class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-655 text-slate-750 dark:text-slate-200 px-4 rounded-xl text-xs font-bold transition cursor-pointer"><i class="fas fa-plus"></i></button>
                        </div>
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            <template x-for="(tamano, index) in productFeatures.tamanos" :key="index">
                                <span class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-[10px] font-bold pl-3 pr-2 py-1 rounded-xl flex items-center gap-1.5 shadow-sm">
                                    <span x-text="tamano"></span>
                                    <button type="button" @click="removeTamano(index)" class="text-slate-400 hover:text-rose-500 text-xs cursor-pointer"><i class="fas fa-times"></i></button>
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- Panel Otros -->
                    <div x-show="enableOtros" x-cloak x-transition class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 space-y-3">
                        <label class="block text-[9px] font-extrabold text-primary uppercase tracking-widest">Otras Características Personalizadas</label>
                        
                        <!-- Dropdown de presets de Nombre de Característica -->
                        <div class="space-y-1">
                            <span class="block text-[9px] font-bold text-primary/80 uppercase tracking-wider">1. Tipo de Característica</span>
                            <select id="selectedOtroPreset" x-model="selectedOtroPreset" @change="handleOtroPresetSelect()" class="select2-enable w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none">
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
                            <span class="block text-[9px] font-bold text-primary/80 uppercase tracking-wider">Nombre Seleccionado</span>
                            <input type="text" x-model="tempOtroName" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none" placeholder="Ej: Tipo de Pan, Adicionales...">
                        </div>

                        <!-- Creador de valores con sugerencias de presets y botones táctiles móviles -->
                        <template x-if="tempOtroName.trim()">
                            <div class="space-y-2 pt-1 border-t border-slate-200/40 dark:border-slate-800/40">
                                <!-- Sugerencias rápidas (Chips dinámicos en base al nombre de la característica) -->
                                <div class="space-y-1" x-show="getOtroValuePresets().length > 0">
                                    <span class="block text-[9px] font-black text-primary/80 uppercase tracking-wider">Sugerencias rápidas (Toca para agregar):</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        <template x-for="pVal in getOtroValuePresets()">
                                            <button type="button" @click="addOtroValuePreset(pVal)" class="bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-750 text-slate-700 dark:text-slate-300 text-[10px] font-bold px-2.5 py-1 rounded-xl border border-slate-200 dark:border-slate-700/80 shadow-sm transition active:scale-95 cursor-pointer">
                                                + <span x-text="pVal"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <span class="block text-[9px] font-bold text-primary/80 uppercase tracking-wider">2. Opciones / Valores de la Característica</span>
                                    <div class="flex gap-2">
                                        <input type="text" x-model="tempOtroSingleValue" @keydown.enter.prevent="addOtroValue()" class="flex-grow bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none" placeholder="Ej: Integral, Brioche, Sin Queso...">
                                        <button type="button" @click="addOtroValue()" class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-655 text-slate-750 dark:text-slate-200 px-4 rounded-xl text-xs font-bold transition flex items-center justify-center cursor-pointer">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Chips de valores que se están configurando en caliente -->
                                <div class="flex flex-wrap gap-1.5 pt-1" x-show="tempOtroValuesList.length > 0">
                                    <template x-for="(val, vIdx) in tempOtroValuesList" :key="vIdx">
                                        <span class="bg-primary/5 dark:bg-primary/20 border border-primary/10 text-primary dark:text-primary-light text-[10px] font-bold pl-3 pr-2 py-1 rounded-xl flex items-center gap-1.5 shadow-sm">
                                            <span x-text="val"></span>
                                            <button type="button" @click="removeOtroValue(vIdx)" class="text-primary hover:text-rose-500 text-xs cursor-pointer"><i class="fas fa-times"></i></button>
                                        </span>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- Botón principal para consolidar la característica -->
                        <button type="button" @click="addOtro()" 
                                :disabled="!tempOtroName.trim() || tempOtroValuesList.length === 0"
                                :class="(!tempOtroName.trim() || tempOtroValuesList.length === 0) ? 'opacity-50 cursor-not-allowed bg-slate-200 dark:bg-slate-700 text-slate-400' : 'bg-primary text-white hover:bg-primary/90 shadow-sm'"
                                class="w-full py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 cursor-pointer mt-2">
                            <i class="fas fa-check"></i> Registrar Característica
                        </button>

                        <!-- Listado de Características ya guardadas para este producto -->
                        <div class="flex flex-col gap-2 pt-2 border-t border-slate-100 dark:border-slate-800/80" x-show="productFeatures.otros.length > 0">
                            <span class="block text-[9px] font-black text-primary uppercase tracking-widest mb-1">Características Registradas:</span>
                            <template x-for="(otro, index) in productFeatures.otros" :key="index">
                                <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-3 rounded-xl flex items-center justify-between text-xs shadow-sm">
                                    <div>
                                        <span class="font-extrabold text-slate-750 dark:text-slate-355" x-text="otro.nombre + ': '"></span>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            <template x-for="v in otro.valores">
                                                <span class="bg-slate-50 dark:bg-slate-750 text-slate-600 dark:text-slate-300 text-[9px] font-bold px-2 py-0.5 rounded border border-slate-150 dark:border-slate-700" x-text="v"></span>
                                            </template>
                                        </div>
                                    </div>
                                    <button type="button" @click="removeOtro(index)" class="text-slate-400 hover:text-rose-500 transition cursor-pointer self-start p-1"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Imagen del Producto -->
                <div>
                    <label class="block text-[10px] font-black text-primary uppercase tracking-widest mb-2">Imagen del Producto</label>
                    <div class="flex items-center gap-4">
                        <!-- Preview -->
                        <div class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-800 border border-slate-200/50 dark:border-slate-700/80 overflow-hidden flex items-center justify-center shrink-0">
                            <template x-if="productImagePreview">
                                <img :src="productImagePreview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!productImagePreview">
                                <svg width="20" height="20" class="text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                            </template>
                        </div>
                        <!-- Upload input -->
                        <div class="flex-grow">
                            <input type="file" id="image" accept="image/*" @change="handleImageChange" class="hidden">
                            <button type="button" onclick="document.getElementById('image').click()" class="bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 text-slate-700 dark:text-slate-300 text-xs font-bold px-4 py-2.5 rounded-xl transition cursor-pointer flex items-center gap-2">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                Cargar Imagen
                            </button>
                            <span class="text-[9px] text-slate-400 block mt-1">Formatos sugeridos: JPG, PNG. Máximo 2MB.</span>
                        </div>
                    </div>
                    <p x-show="errors.image" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.image"></p>
                </div>
            </div>

            <!-- Botones de Acción (Footer Sticky con color primario) -->
            <div class="px-6 py-4 bg-primary flex justify-end gap-3 sticky bottom-0 z-10 shadow-[0_-4px_12px_rgba(0,0,0,0.08)] border-t border-black/10 transition-colors">
                <button type="button" @click="closeModal()" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs px-5 py-3 rounded-xl transition shadow-sm active:scale-95">
                    Cancelar
                </button>
                <button type="submit" class="bg-white hover:bg-white/95 text-primary font-black text-xs px-6 py-3 rounded-xl transition shadow-md active:scale-95 flex items-center gap-2">
                    <span x-text="isEdit ? 'Guardar Cambios' : 'Crear Producto'">Crear Producto</span>
                </button>
            </div>
            </form>
        </div>
    </div>
    </template>
</div>

<script>
    let datatable;

    $(document).ready(function() {
        // Inicializar DataTables con opciones premium
        datatable = $('#productsTable').DataTable({
            processing: true,
            ajax: {
                url: window.location.pathname,
                dataSrc: 'data'
            },
            columns: [
                { 
                    data: 'image_path',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        const path = data ? (data.startsWith('http') ? data : '/storage/' + data) : null;
                        if (path) {
                            return `<div class="w-12 h-12 rounded-xl overflow-hidden border border-slate-100 dark:border-slate-800/80 shadow-sm"><img src="${path}" class="w-full h-full object-cover"></div>`;
                        } else {
                            return `<div class="w-12 h-12 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700/80 flex items-center justify-center text-slate-400"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg></div>`;
                        }
                    }
                },
                { 
                    data: 'name',
                    render: function(data) {
                        return `<div class="font-bold text-slate-800 dark:text-slate-200 text-sm">${data}</div>`;
                    }
                },
                { 
                    data: 'description',
                    render: function(data) {
                        return `<div class="text-xs text-slate-500 dark:text-slate-400 max-w-xs line-clamp-2" title="${data || ''}">${data || '<span class="italic text-slate-400">Sin descripción</span>'}</div>`;
                    }
                },
                { 
                    data: 'category.name',
                    render: function(data) {
                        return `<span class="bg-primary/5 text-primary text-[10px] font-black px-3 py-1 rounded-full border border-primary/10 whitespace-nowrap">${data}</span>`;
                    }
                },
                { 
                    data: 'price',
                    render: function(data) {
                        return `<div class="font-extrabold text-slate-800 dark:text-slate-100">$${parseFloat(data).toFixed(2)}</div>`;
                    }
                },
                { 
                    data: 'is_available',
                    render: function(data) {
                        if (data) {
                            return `<span class="bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 text-[10px] font-black px-2.5 py-1 rounded-full border border-emerald-200/30">Disponible</span>`;
                        } else {
                            return `<span class="bg-rose-100 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 text-[10px] font-black px-2.5 py-1 rounded-full border border-rose-200/30">Agotado</span>`;
                        }
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        const descriptionEscaped = row.description ? row.description.replace(/'/g, "\\'") : '';
                        const nameEscaped = row.name.replace(/'/g, "\\'");
                        const featuresEscaped = encodeURIComponent(JSON.stringify(row.features || null));
                        const preparationTimeEscaped = row.preparation_time ? row.preparation_time.replace(/'/g, "\\'") : '';
                        return `
                            <div class="flex items-center gap-2">
                                <button onclick="editProduct(${row.id}, '${nameEscaped}', ${row.category_id}, ${row.price}, '${descriptionEscaped}', ${row.is_available}, '${row.image_path || ''}', '${featuresEscaped}', '${preparationTimeEscaped}')" class="p-2 bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700 hover:border-primary rounded-xl text-slate-600 dark:text-slate-400 hover:text-primary transition-all shadow-sm cursor-pointer" title="Editar">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>
                                <button onclick="deleteProduct(${row.id})" class="p-2 bg-rose-50 dark:bg-rose-950/30 border border-rose-100/40 hover:border-rose-500 rounded-xl text-rose-600 dark:text-rose-400 hover:text-white hover:bg-rose-500 transition-all shadow-sm cursor-pointer" title="Eliminar">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            language: {
                processing: "Cargando productos...",
                search: "",
                searchPlaceholder: "Buscar...",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros totales)",
                paginate: {
                    first: "Primero",
                    previous: "‹",
                    next: "›",
                    last: "Último"
                },
                emptyTable: "No se encontraron productos en el inventario de la tienda."
            },
            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4"l<"flex items-center gap-3"Bf>>t<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-4"ip>',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<span class="flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> Excel</span>',
                    className: 'btn-export-excel',
                    titleAttr: 'Exportar a Excel',
                    filename: function() {
                        return ('Reporte_Productos_{{ config('current_shop')->slug }}').replace(/[\r\n\t]/g, '').replace(/[^a-zA-Z0-9_-]/g, '_').trim();
                    },
                    title: function() {
                        return ('Reporte de Productos - {{ config('current_shop')->name }}').replace(/[\r\n\t]/g, '').trim();
                    },
                    messageTop: function() {
                        let dt = $('#productsTable').DataTable();
                        let total = dt.rows({ search: 'applied' }).count();
                        let date = new Date().toLocaleDateString('es-ES');
                        return 'Reporte: Productos | Generado el: ' + date + ' | Total Registros: ' + total;
                    },
                    customize: function(xlsx) {
                        let brandColor = '{{ config('current_shop')->color_primary ?? '#E60067' }}';
                        window.applyCustomExcelStyle(xlsx, brandColor);
                    },
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    text: '<span class="flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> PDF</span>',
                    className: 'btn-export-pdf',
                    titleAttr: 'Vista Previa de Impresión',
                    action: function (e, dt, node, config) {
                        openPrintPreview(dt);
                    }
                }
            ]
        });
    });

    // Delegación de Alpine a Javascript
    function editProduct(id, name, categoryId, price, description, isAvailable, imagePath, featuresUrlEncoded, preparationTime) {
        let features = null;
        try {
            if (featuresUrlEncoded && featuresUrlEncoded !== 'undefined' && featuresUrlEncoded !== 'null') {
                features = JSON.parse(decodeURIComponent(featuresUrlEncoded));
            }
        } catch(e) {
            console.error('Error decoding features:', e);
        }
        Alpine.$data(document.getElementById('products-page')).openEdit(id, name, categoryId, price, description, isAvailable, imagePath, features, preparationTime);
    }

    // Toast de SweetAlert2 con colores de la tienda
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    // Envío del Formulario (Soporta archivo)
    function submitForm(alpineData) {
        let url = '/{{ config('current_shop')->slug }}/admin/products';
        let method = 'POST';

        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('name', alpineData.productName);
        formData.append('category_id', alpineData.productCategoryId);
        formData.append('price', alpineData.productPrice);
        formData.append('description', alpineData.productDescription);
        formData.append('is_available', alpineData.productIsAvailable);
        formData.append('preparation_time', alpineData.productPreparationTime);

        // Filter and stringify features config
        let activeFeatures = {
            medidas: alpineData.enableMedidas ? alpineData.productFeatures.medidas : [],
            sabores: alpineData.enableSabores ? alpineData.productFeatures.sabores : [],
            colores: alpineData.enableColores ? alpineData.productFeatures.colores : [],
            tamanos: alpineData.enableTamanos ? alpineData.productFeatures.tamanos : [],
            otros: alpineData.enableOtros ? alpineData.productFeatures.otros : []
        };
        formData.append('features', JSON.stringify(activeFeatures));

        const imageFile = document.getElementById('image').files[0];
        if (imageFile) {
            formData.append('image', imageFile);
        }

        if (alpineData.isEdit) {
            url += '/' + alpineData.productId;
            // Para simular PUT con FormData de Laravel
            formData.append('_method', 'PUT');
        }

        $.ajax({
            url: url,
            type: 'POST', // Siempre POST para subir archivos
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    alpineData.closeModal();
                    datatable.ajax.reload();
                    
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    alpineData.errors = {};
                    let errors = xhr.responseJSON.errors;
                    for (let key in errors) {
                        alpineData.errors[key] = errors[key][0];
                    }
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Ocurrió un error inesperado al procesar la solicitud.'
                    });
                }
            }
        });
    }

    // Eliminar Producto
    function deleteProduct(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer y eliminará el producto del inventario.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/{{ config('current_shop')->slug }}/admin/products/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            datatable.ajax.reload();
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                        }
                    },
                    error: function() {
                        Toast.fire({
                            icon: 'error',
                            title: 'Ocurrió un error al intentar eliminar el producto.'
                        });
                    }
                });
            }
        });
    }
    // Autoloader for Edit Modal from Search
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const editId = urlParams.get('edit_id');
        if (editId) {
            $.ajax({
                url: `/{{ config('current_shop')->slug }}/admin/products/${editId}`,
                type: 'GET',
                success: function(res) {
                    if (res.success && res.data) {
                        editProduct(res.data.id, res.data.name, res.data.category_id, res.data.price, res.data.description, res.data.is_available, res.data.image_path, encodeURIComponent(JSON.stringify(res.data.features || null)));
                        window.history.replaceState({}, document.title, window.location.pathname);
                    }
                }
            });
        }
    });
</script>
@endsection
