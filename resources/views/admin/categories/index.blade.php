@extends('layouts.admin')

@section('title', 'Gestión de Categorías')
@section('subtitle', 'Estructura tu Catálogo')
@section('header_title', 'Categorías de Productos')

@section('content')
<div x-data="{ 
    showModal: false, 
    isEdit: false, 
    categoryId: null,
    categoryName: '',
    categoryStatus: 1,
    categoryIcon: '',
    categoryColor: '#E60067',
    errors: {},
    
    openCreate() {
        this.isEdit = false;
        this.categoryId = null;
        this.categoryName = '';
        this.categoryStatus = 1;
        this.categoryIcon = '';
        this.categoryColor = '#E60067';
        this.errors = {};
        this.showModal = true;
    },
    openEdit(id, name, status, icon, color) {
        this.isEdit = true;
        this.categoryId = id;
        this.categoryName = name;
        this.categoryStatus = status ? 1 : 0;
        this.categoryIcon = icon || '';
        this.categoryColor = color || '#E60067';
        this.errors = {};
        this.showModal = true;
    },
    closeModal() {
        this.showModal = false;
        this.errors = {};
    },
    init() {
        this.$watch('showModal', value => {
            if (value) {
                this.$nextTick(() => {
                    $('#status').select2({
                        width: '100%',
                        dropdownParent: $('#categoryForm'),
                        minimumResultsForSearch: Infinity
                    });
                    
                    $('#status').on('change', (e) => {
                        this.categoryStatus = parseInt(e.target.value);
                    });

                    $('#status').val(this.categoryStatus).trigger('change.select2');
                });
            } else {
                $('#status').select2('destroy');
            }
        });
    }
}" id="categories-page" class="space-y-6">

    <!-- Tarjeta Principal de Control (Estilo Nómina del Personal) -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] p-6 md:p-8 transition-all duration-300">
        
        <!-- Encabezado de la Sección -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h2 class="text-xl md:text-2xl font-black text-slate-800 dark:text-slate-100 tracking-tight">Categorías de Productos</h2>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Crea y administra las categorías comerciales para agrupar tus artículos y optimizar el catálogo de tu tienda.
                </p>
            </div>
            <div>
                <button @click="openCreate()" class="bg-primary hover:bg-primary/90 text-white font-extrabold text-xs px-5 py-3 rounded-xl transition shadow-md hover:shadow-lg shadow-black/5 dark:shadow-black/20 active:scale-95 flex items-center justify-center gap-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Registrar Categoría
                </button>
            </div>
        </div>

        <!-- Tabla de Datos con Estilo Moderno -->
        <div class="overflow-x-auto pt-4">
            <table id="categoriesTable" class="w-full text-left">
                <thead>
                    <tr>
                        <th>Nombre de la Categoría</th>
                        <th>Slug Identificador</th>
                        <th>Productos</th>
                        <th>Estado</th>
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
    @include('modals.category')
</div>

@push('scripts')
    @include('partials.categories.js')
@endpush
@endsection
