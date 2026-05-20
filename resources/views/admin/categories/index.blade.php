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
    errors: {},
    
    openCreate() {
        this.isEdit = false;
        this.categoryId = null;
        this.categoryName = '';
        this.categoryStatus = 1;
        this.errors = {};
        this.showModal = true;
    },
    openEdit(id, name, status) {
        this.isEdit = true;
        this.categoryId = id;
        this.categoryName = name;
        this.categoryStatus = status ? 1 : 0;
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
    <template x-teleport="body">
        <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <!-- Backdrop -->
            <div x-show="showModal" x-transition.opacity.duration.300ms class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeModal()"></div>
            
            <!-- Contenedor del Modal -->
            <form id="categoryForm" @submit.prevent="submitForm($data)"
              x-show="showModal" 
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
              x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              class="relative bg-white dark:bg-slate-900 rounded-3xl shadow-2xl w-full max-w-md overflow-hidden flex flex-col transition-colors duration-300">
            
            <!-- Encabezado (Header Sticky con color primario) -->
            <div class="px-6 py-5 border-b border-black/10 dark:border-white/10 flex items-center justify-between sticky top-0 z-10 bg-primary text-white transition-colors duration-300 shadow-md">
                <div>
                    <span class="text-[9px] uppercase font-extrabold tracking-widest text-white/70" x-text="isEdit ? 'Editar Registro' : 'Nuevo Registro'">Nuevo Registro</span>
                    <h3 class="text-base md:text-lg font-black text-white mt-0.5" x-text="isEdit ? 'Modificar Categoría' : 'Registrar Categoría'">Registrar Categoría</h3>
                </div>
                <button type="button" @click="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-all duration-200">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>

            <!-- Formulario (Scrollable Body) -->
            <div class="p-6 space-y-4 overflow-y-auto flex-grow">
                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Nombre de la Categoría</label>
                    <input type="text" id="name" x-model="categoryName" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: Globos y Detalles">
                    <p x-show="errors.name" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.name"></p>
                </div>

                <!-- Estado -->
                <div>
                    <label for="status" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Estado</label>
                    <select id="status" x-model="categoryStatus" class="select2-enable w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                        <option value="1">Activa</option>
                        <option value="0">Inactiva</option>
                    </select>
                </div>
            </div>

            <!-- Botones de Acción (Footer Sticky con color primario) -->
            <div class="px-6 py-4 bg-primary flex justify-end gap-3 sticky bottom-0 z-10 shadow-[0_-4px_12px_rgba(0,0,0,0.08)] border-t border-black/10 transition-colors">
                <button type="button" @click="closeModal()" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs px-5 py-3 rounded-xl transition shadow-sm active:scale-95">
                    Cancelar
                </button>
                <button type="submit" class="bg-white hover:bg-white/95 text-primary font-black text-xs px-6 py-3 rounded-xl transition shadow-md active:scale-95 flex items-center gap-2">
                    <span x-text="isEdit ? 'Guardar Cambios' : 'Crear Categoría'">Crear Categoría</span>
                </button>
            </div>
            </form>
        </div>
    </template>
</div>

<script>
    let datatable;

    $(document).ready(function() {
        // Inicializar DataTables con opciones premium
        datatable = $('#categoriesTable').DataTable({
            processing: true,
            ajax: {
                url: window.location.pathname,
                dataSrc: 'data'
            },
            columns: [
                { 
                    data: 'name',
                    render: function(data, type, row) {
                        return `<div class="font-bold text-slate-800 dark:text-slate-200">${data}</div>`;
                    }
                },
                { 
                    data: 'slug',
                    render: function(data) {
                        return `<code class="bg-slate-100 dark:bg-slate-800 text-[10px] font-mono px-2 py-1 rounded-md text-slate-600 dark:text-slate-400">${data}</code>`;
                    }
                },
                { 
                    data: 'products_count',
                    render: function(data) {
                        return `<span class="bg-slate-100 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 text-[10px] font-extrabold px-2.5 py-1 rounded-full border border-slate-200/40">${data} artículos</span>`;
                    }
                },
                { 
                    data: 'status',
                    render: function(data) {
                        if (data) {
                            return `<span class="bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 text-[10px] font-black px-2.5 py-1 rounded-full border border-emerald-200/30">Activa</span>`;
                        } else {
                            return `<span class="bg-rose-100 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 text-[10px] font-black px-2.5 py-1 rounded-full border border-rose-200/30">Inactiva</span>`;
                        }
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <div class="flex items-center gap-2">
                                <button onclick="editCategory(${row.id}, '${row.name.replace(/'/g, "\\'")}', ${row.status})" class="p-2 bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700 hover:border-primary rounded-xl text-slate-600 dark:text-slate-400 hover:text-primary transition-all shadow-sm cursor-pointer" title="Editar">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>
                                <button onclick="deleteCategory(${row.id})" class="p-2 bg-rose-50 dark:bg-rose-950/30 border border-rose-100/40 hover:border-rose-500 rounded-xl text-rose-600 dark:text-rose-400 hover:text-white hover:bg-rose-500 transition-all shadow-sm cursor-pointer" title="Eliminar">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            language: {
                processing: "Cargando categorías...",
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
                emptyTable: "No se encontraron categorías comerciales en la tienda."
            },
            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4"l<"flex items-center gap-3"Bf>>t<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-4"ip>',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<span class="flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> Excel</span>',
                    className: 'btn-export-excel',
                    titleAttr: 'Exportar a Excel',
                    filename: function() {
                        return ('Reporte_Categorias_{{ config('current_shop')->slug }}').replace(/[\r\n\t]/g, '').replace(/[^a-zA-Z0-9_-]/g, '_').trim();
                    },
                    title: function() {
                        return ('Reporte de Categorías - {{ config('current_shop')->name }}').replace(/[\r\n\t]/g, '').trim();
                    },
                    messageTop: function() {
                        let dt = $('#categoriesTable').DataTable();
                        let total = dt.rows({ search: 'applied' }).count();
                        let date = new Date().toLocaleDateString('es-ES');
                        return 'Reporte: Categorías | Generado el: ' + date + ' | Total Registros: ' + total;
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
    function editCategory(id, name, status) {
        Alpine.$data(document.getElementById('categories-page')).openEdit(id, name, status);
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

    // Envío del Formulario
    function submitForm(alpineData) {
        let url = '/{{ config('current_shop')->slug }}/admin/categories';
        let method = 'POST';

        if (alpineData.isEdit) {
            url += '/' + alpineData.categoryId;
            method = 'PUT';
        }

        $.ajax({
            url: url,
            type: method,
            data: {
                _token: '{{ csrf_token() }}',
                name: alpineData.categoryName,
                status: alpineData.categoryStatus
            },
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

    // Eliminar Categoría
    function deleteCategory(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer y eliminará la categoría.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/{{ config('current_shop')->slug }}/admin/categories/' + id,
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
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        let msg = 'Ocurrió un error al intentar eliminar la categoría.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'No se puede eliminar',
                            text: msg
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
                url: `/{{ config('current_shop')->slug }}/admin/categories/${editId}`,
                type: 'GET',
                success: function(res) {
                    if (res.success && res.data) {
                        editCategory(res.data.id, res.data.name, res.data.status);
                        window.history.replaceState({}, document.title, window.location.pathname);
                    }
                }
            });
        }
    });
</script>
@endsection
