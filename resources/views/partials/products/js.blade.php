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
