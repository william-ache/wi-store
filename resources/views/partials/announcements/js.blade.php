<script>
    let datatable;

    $(document).ready(function() {
        datatable = $('#announcementsTable').DataTable({
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
                        if (data) {
                            return `<img src="/storage/${data}" class="w-12 h-12 object-cover rounded-xl border border-slate-100 dark:border-slate-800 shadow-sm">`;
                        }
                        return `
                            <div class="w-12 h-12 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200/40 flex items-center justify-center text-slate-400 text-xs shrink-0">
                                📢
                            </div>
                        `;
                    }
                },
                { 
                    data: 'title',
                    render: function(data, type, row) {
                        let contentText = row.content ? row.content : '';
                        if (contentText.length > 50) {
                            contentText = contentText.substring(0, 50) + '...';
                        }
                        return `
                            <div>
                                <div class="font-extrabold text-slate-800 dark:text-slate-200 leading-snug">${data}</div>
                                <div class="text-[11px] text-slate-455 dark:text-slate-500 mt-0.5 leading-relaxed font-semibold">${contentText}</div>
                            </div>
                        `;
                    }
                },
                { 
                    data: 'expires_at',
                    render: function(data) {
                        if (!data) {
                            return `<span class="bg-slate-100 dark:bg-slate-800 text-slate-650 dark:text-slate-400 text-[10px] font-extrabold px-2.5 py-1 rounded-full">Sin fecha límite</span>`;
                        }
                        const expires = new Date(data);
                        const today = new Date();
                        today.setHours(0,0,0,0);
                        expires.setHours(0,0,0,0);
                        
                        // Parse spanish date format
                        const opt = { day: '2-digit', month: 'short', year: 'numeric' };
                        const formatted = expires.toLocaleDateString('es-ES', opt);

                        if (expires < today) {
                            return `
                                <div class="flex flex-col items-start gap-1">
                                    <span class="bg-rose-100 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 text-[9px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider">Expirado</span>
                                    <span class="text-[10px] text-slate-400 font-mono font-bold">${formatted}</span>
                                </div>
                            `;
                        } else {
                            return `
                                <div class="flex flex-col items-start gap-1">
                                    <span class="bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 text-[9px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider">Vigente</span>
                                    <span class="text-[10px] text-slate-500 dark:text-slate-400 font-mono font-bold">${formatted}</span>
                                </div>
                            `;
                        }
                    }
                },
                {
                    data: 'button_text',
                    render: function(data, type, row) {
                        if (data && row.button_link) {
                            return `
                                <a href="${row.button_link}" target="_blank" class="inline-flex items-center gap-1.5 text-primary hover:text-primary-dark font-extrabold text-xs transition">
                                    ${data} 
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                                </a>
                            `;
                        }
                        return `<span class="text-slate-400 font-bold text-xs">Ninguna</span>`;
                    }
                },
                { 
                    data: 'is_active',
                    render: function(data) {
                        if (data) {
                            return `<span class="bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 text-[10px] font-black px-2.5 py-1 rounded-full border border-emerald-200/30">Visible</span>`;
                        } else {
                            return `<span class="bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-450 text-[10px] font-black px-2.5 py-1 rounded-full border border-slate-200/40">Inactivo</span>`;
                        }
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        const titleEscaped = row.title.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                        const contentEscaped = row.content ? row.content.replace(/'/g, "\\'").replace(/"/g, '&quot;') : '';
                        const imagePathVal = row.image_path ? row.image_path : '';
                        const btnTextEscaped = row.button_text ? row.button_text.replace(/'/g, "\\'").replace(/"/g, '&quot;') : '';
                        const btnLinkEscaped = row.button_link ? row.button_link.replace(/'/g, "\\'") : '';
                        const expiresAtVal = row.expires_at ? row.expires_at : '';
                        
                        return `
                            <div class="flex items-center gap-2">
                                <button onclick="editAnnouncement(${row.id}, '${titleEscaped}', '${contentEscaped}', '${imagePathVal}', '${btnTextEscaped}', '${btnLinkEscaped}', '${expiresAtVal}', ${row.is_active})" class="p-2 bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700 hover:border-primary rounded-xl text-slate-600 dark:text-slate-400 hover:text-primary transition-all shadow-sm cursor-pointer" title="Editar">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>
                                <button onclick="deleteAnnouncement(${row.id})" class="p-2 bg-rose-50 dark:bg-rose-950/30 border border-rose-100/40 hover:border-rose-500 rounded-xl text-rose-600 dark:text-rose-400 hover:text-white hover:bg-rose-500 transition-all shadow-sm cursor-pointer" title="Eliminar">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            language: {
                processing: "Cargando anuncios...",
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
                emptyTable: "No se encontraron anuncios activos o programados en tu tienda."
            },
            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4"l<"flex items-center gap-3"Bf>>t<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-4"ip>',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<span class="flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> Excel</span>',
                    className: 'btn-export-excel',
                    titleAttr: 'Exportar a Excel',
                    filename: function() {
                        return ('Reporte_Anuncios_{{ config('current_shop')->slug }}').replace(/[\r\n\t]/g, '').replace(/[^a-zA-Z0-9_-]/g, '_').trim();
                    },
                    title: function() {
                        return ('Reporte de Anuncios - {{ config('current_shop')->name }}').replace(/[\r\n\t]/g, '').trim();
                    },
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }
            ]
        });
    });

    function editAnnouncement(id, title, content, imagePath, buttonText, buttonLink, expiresAt, isActive) {
        Alpine.$data(document.getElementById('announcements-page')).openEdit(id, title, content, imagePath, buttonText, buttonLink, expiresAt, isActive);
    }

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

    function submitForm(alpineData) {
        let url = '/{{ config('current_shop')->slug }}/admin/announcements';
        let method = 'POST';

        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('title', alpineData.announcementTitle);
        formData.append('content', alpineData.announcementContent);
        formData.append('button_text', alpineData.announcementButtonText);
        formData.append('button_link', alpineData.announcementButtonLink);
        formData.append('expires_at', alpineData.announcementExpiresAt);
        formData.append('is_active', alpineData.announcementIsActive);

        const imageFile = document.getElementById('image').files[0];
        if (imageFile) {
            formData.append('image', imageFile);
        }

        if (alpineData.isEdit) {
            url += '/' + alpineData.announcementId;
            formData.append('_method', 'PUT');
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Update dynamic Alpine count on create
                    if (!alpineData.isEdit) {
                        alpineData.announcementCount++;
                    }
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
                    let errMsg = 'Ocurrió un error inesperado al procesar la solicitud.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errMsg = xhr.responseJSON.message;
                    }
                    Toast.fire({
                        icon: 'error',
                        title: errMsg
                    });
                }
            }
        });
    }

    function deleteAnnouncement(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer y ocultará permanentemente la promoción de tu catálogo.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/{{ config('current_shop')->slug }}/admin/announcements/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update Alpine count
                            const alpineData = Alpine.$data(document.getElementById('announcements-page'));
                            alpineData.announcementCount--;
                            
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
                            title: 'Ocurrió un error al intentar eliminar el anuncio.'
                        });
                    }
                });
            }
        });
    }
</script>
