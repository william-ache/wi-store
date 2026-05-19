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
    errors: {},
    
    openCreate() {
        this.isEdit = false;
        this.productId = null;
        this.productName = '';
        this.productCategoryId = '';
        this.productPrice = '';
        this.productDescription = '';
        this.productIsAvailable = 1;
        this.productImagePreview = null;
        document.getElementById('image').value = '';
        this.errors = {};
        this.showModal = true;
    },
    openEdit(id, name, categoryId, price, description, isAvailable, imagePath) {
        this.isEdit = true;
        this.productId = id;
        this.productName = name;
        this.productCategoryId = categoryId;
        this.productPrice = price;
        this.productDescription = description || '';
        this.productIsAvailable = isAvailable ? 1 : 0;
        this.productImagePreview = imagePath ? (imagePath.startsWith('http') ? imagePath : '/storage/' + imagePath) : null;
        document.getElementById('image').value = '';
        this.errors = {};
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
                <button @click="openCreate()" class="bg-primary hover:bg-primary/90 text-white font-extrabold text-xs px-5 py-3 rounded-xl transition shadow-[0_4px_12px_rgba(230,0,103,0.2)] hover:shadow-[0_4px_20px_rgba(230,0,103,0.3)] active:scale-95 flex items-center justify-center gap-2">
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
    <div x-show="showModal" x-cloak class="fixed inset-0 z-40 flex items-center justify-center p-4">
        <!-- Backdrop -->
        <div x-show="showModal" x-transition.opacity.duration.300ms class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeModal()"></div>
        
        <!-- Contenedor del Modal -->
        <div x-show="showModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white dark:bg-slate-900 rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col transition-colors duration-300 max-h-[90vh]">
            
            <!-- Encabezado -->
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between sticky top-0 z-10 bg-white dark:bg-slate-900 transition-colors duration-300">
                <div>
                    <span class="text-[9px] uppercase font-extrabold tracking-widest text-slate-400" x-text="isEdit ? 'Editar Registro' : 'Nuevo Registro'">Nuevo Registro</span>
                    <h3 class="text-base md:text-lg font-black text-slate-800 dark:text-slate-100 mt-0.5" x-text="isEdit ? 'Modificar Producto' : 'Registrar Producto'">Registrar Producto</h3>
                </div>
                <button @click="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>

            <!-- Formulario (Scrollable) -->
            <form id="productForm" @submit.prevent="submitForm($data)" class="p-6 space-y-4 overflow-y-auto flex-grow">
                <!-- Nombre y Categoría en Fila -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Nombre del Producto</label>
                        <input type="text" id="name" x-model="productName" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: Arreglo Globos Premium">
                        <p x-show="errors.name" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.name"></p>
                    </div>
                    <div>
                        <label for="category_id" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Categoría</label>
                        <select id="category_id" x-model="productCategoryId" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
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
                        <label for="price" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Precio ($)</label>
                        <input type="number" step="0.01" id="price" x-model="productPrice" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: 25.00">
                        <p x-show="errors.price" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.price"></p>
                    </div>
                    <div>
                        <label for="is_available" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Disponibilidad</label>
                        <select id="is_available" x-model="productIsAvailable" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                            <option value="1">Disponible / Activo</option>
                            <option value="0">Agotado / Inactivo</option>
                        </select>
                    </div>
                </div>

                <!-- Descripción -->
                <div>
                    <label for="description" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Descripción o Detalles</label>
                    <textarea id="description" x-model="productDescription" rows="3" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition resize-none" placeholder="Ingresa los detalles del producto..."></textarea>
                    <p x-show="errors.description" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.description"></p>
                </div>

                <!-- Imagen del Producto -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Imagen del Producto</label>
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

                <!-- Botones de Acción -->
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" @click="closeModal()" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 font-bold text-xs px-5 py-3 rounded-xl transition shadow-sm active:scale-95">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-primary hover:bg-primary/95 text-white font-extrabold text-xs px-6 py-3 rounded-xl transition shadow-[0_4px_12px_rgba(230,0,103,0.2)] active:scale-95 flex items-center gap-2">
                        <span x-text="isEdit ? 'Guardar Cambios' : 'Crear Producto'">Crear Producto</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
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
                        return `
                            <div class="flex items-center gap-2">
                                <button onclick="editProduct(${row.id}, '${nameEscaped}', ${row.category_id}, ${row.price}, '${descriptionEscaped}', ${row.is_available}, '${row.image_path || ''}')" class="p-2 bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700 hover:border-primary rounded-xl text-slate-600 dark:text-slate-400 hover:text-primary transition-all shadow-sm cursor-pointer" title="Editar">
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
    function editProduct(id, name, categoryId, price, description, isAvailable, imagePath) {
        Alpine.$data(document.getElementById('products-page')).openEdit(id, name, categoryId, price, description, isAvailable, imagePath);
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
</script>
@endsection
