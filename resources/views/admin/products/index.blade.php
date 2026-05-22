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
    @include('modals.product')
</div>

@push('scripts')
    @include('partials.products.js')
@endpush
@endsection
