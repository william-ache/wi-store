@extends('layouts.admin')

@section('title', 'Gestión de Anuncios')
@section('subtitle', 'Llama la Atención de tus Clientes')
@section('header_title', 'Anuncios Emergentes')

@section('content')
<div x-data="{ 
    showModal: false, 
    isEdit: false, 
    announcementId: null,
    announcementTitle: '',
    announcementContent: '',
    announcementImagePreview: null,
    announcementButtonText: '',
    announcementButtonLink: '',
    announcementExpiresAt: '',
    announcementIsActive: 1,
    announcementCount: {{ $count }},
    errors: {},
    
    openCreate() {
        if (this.announcementCount >= 3) {
            Swal.fire({
                icon: 'warning',
                title: 'Límite alcanzado',
                text: 'Has alcanzado el límite de 3 anuncios. Elimina uno existente para crear otro.',
                confirmButtonColor: 'var(--color-primary)'
            });
            return;
        }
        this.isEdit = false;
        this.announcementId = null;
        this.announcementTitle = '';
        this.announcementContent = '';
        this.announcementImagePreview = null;
        this.announcementButtonText = '';
        this.announcementButtonLink = '';
        this.announcementExpiresAt = '';
        this.announcementIsActive = 1;
        document.getElementById('image').value = '';
        this.errors = {};
        this.showModal = true;
    },
    openEdit(id, title, content, imagePath, buttonText, buttonLink, expiresAt, isActive) {
        this.isEdit = true;
        this.announcementId = id;
        this.announcementTitle = title;
        this.announcementContent = content || '';
        this.announcementImagePreview = imagePath ? (imagePath.startsWith('http') ? imagePath : '/storage/' + imagePath) : null;
        this.announcementButtonText = buttonText || '';
        this.announcementButtonLink = buttonLink || '';
        this.announcementExpiresAt = expiresAt || '';
        this.announcementIsActive = isActive ? 1 : 0;
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
            this.announcementImagePreview = URL.createObjectURL(file);
        }
    },
    init() {
        this.$watch('showModal', value => {
            if (value) {
                this.$nextTick(() => {
                    $('#is_active').select2({
                        width: '100%',
                        dropdownParent: $('#announcementForm'),
                        minimumResultsForSearch: Infinity
                    });
                    
                    $('#is_active').on('change', (e) => {
                        this.announcementIsActive = parseInt(e.target.value);
                    });

                    $('#is_active').val(this.announcementIsActive).trigger('change.select2');
                });
            } else {
                $('#is_active').select2('destroy');
            }
        });
    }
}" id="announcements-page" class="space-y-6">

    <!-- Banner Informativo -->
    <div class="bg-gradient-to-r from-blue-500/10 to-indigo-500/10 dark:from-blue-950/40 dark:to-indigo-950/40 border border-blue-100 dark:border-blue-900/40 p-5 rounded-3xl flex items-start gap-4 transition-all">
        <div class="w-10 h-10 rounded-2xl bg-blue-500/20 text-blue-600 dark:text-blue-400 flex items-center justify-center text-lg shrink-0">
            📢
        </div>
        <div>
            <h4 class="font-extrabold text-sm text-slate-800 dark:text-slate-200">Campañas y Anuncios Exclusivos (Máximo 3)</h4>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                Diseña hasta 3 anuncios dinámicos con fecha límite. Cuando el cliente entre a tu menú digital flotante por primera vez, verá estas promociones emergentes en un modal premium con carrusel táctil. El modal guardará el estado de cerrado para asegurar la usabilidad mientras navega.
            </p>
        </div>
    </div>

    <!-- Tarjeta Principal de Control -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] p-6 md:p-8 transition-all duration-300">
        
        <!-- Encabezado de la Sección -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h2 class="text-xl md:text-2xl font-black text-slate-800 dark:text-slate-100 tracking-tight flex items-center gap-2.5">
                    Listado de Anuncios Activos
                    <span class="text-xs font-extrabold px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200/40 text-slate-600 dark:text-slate-400 font-sans tracking-normal" x-text="announcementCount + ' / 3 creados'">0 / 3 creados</span>
                </h2>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Crea, edita y suspende las promociones o alertas de tu menú en tiempo real.
                </p>
            </div>
            <div>
                <button :disabled="announcementCount >= 3" 
                        @click="openCreate()" 
                        :class="announcementCount >= 3 ? 'bg-slate-200 dark:bg-slate-850 text-slate-400 dark:text-slate-600 cursor-not-allowed border border-slate-300/20' : 'bg-primary hover:bg-primary/90 text-white active:scale-95 shadow-md hover:shadow-lg shadow-black/5 dark:shadow-black/20'"
                        class="font-extrabold text-xs px-5 py-3 rounded-xl transition flex items-center justify-center gap-2 cursor-pointer">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span x-text="announcementCount >= 3 ? 'Límite de 3 Alcanzado 🔒' : 'Registrar Anuncio'">Registrar Anuncio</span>
                </button>
            </div>
        </div>

        <!-- Tabla de Datos -->
        <div class="overflow-x-auto pt-4">
            <table id="announcementsTable" class="w-full text-left">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Título del Anuncio</th>
                        <th>Fecha Límite</th>
                        <th>Acción CTA</th>
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
            <form id="announcementForm" @submit.prevent="submitForm($data)"
              x-show="showModal" 
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
              x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              class="relative bg-white dark:bg-slate-900 rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col transition-colors duration-300 max-h-[90vh]">
            
            <!-- Encabezado -->
            <div class="px-6 py-5 border-b border-black/10 dark:border-white/10 flex items-center justify-between sticky top-0 z-10 bg-primary text-white transition-colors duration-300 shadow-md">
                <div>
                    <span class="text-[9px] uppercase font-extrabold tracking-widest text-white/70" x-text="isEdit ? 'Editar Campaña' : 'Nueva Campaña'">Nueva Campaña</span>
                    <h3 class="text-base md:text-lg font-black text-white mt-0.5" x-text="isEdit ? 'Modificar Anuncio' : 'Registrar Anuncio'">Registrar Anuncio</h3>
                </div>
                <button type="button" @click="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-all duration-200">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>

            <!-- Formulario -->
            <div class="p-6 space-y-4 overflow-y-auto flex-grow">
                <!-- Título -->
                <div>
                    <label for="title" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Título del Anuncio</label>
                    <input type="text" id="title" x-model="announcementTitle" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: ¡50% de Descuento en Tortas! 🎂">
                    <p x-show="errors.title" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.title"></p>
                </div>

                <!-- Contenido -->
                <div>
                    <label for="content" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Mensaje o Contenido del Anuncio</label>
                    <textarea id="content" x-model="announcementContent" rows="3" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition resize-none" placeholder="Describe los detalles de tu promoción aquí..."></textarea>
                    <p x-show="errors.content" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.content"></p>
                </div>

                <!-- Imagen Destacada -->
                <div>
                    <label class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Imagen del Anuncio (Opcional - Recomendado)</label>
                    <div class="flex flex-col md:flex-row items-center gap-4">
                        <div class="relative w-full md:w-32 h-32 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden bg-slate-50 dark:bg-slate-800 shrink-0">
                            <template x-if="announcementImagePreview">
                                <img :src="announcementImagePreview" alt="Previsualización" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!announcementImagePreview">
                                <span class="text-[10px] text-slate-400 font-extrabold uppercase text-center p-2">Sin Imagen</span>
                            </template>
                        </div>
                        <div class="flex-grow w-full">
                            <input type="file" id="image" accept="image/*" @change="handleImageChange" class="hidden">
                            <label for="image" class="w-full bg-slate-50 dark:bg-slate-850 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700/80 text-slate-700 dark:text-slate-300 font-extrabold text-[11px] uppercase tracking-wider px-5 py-3 rounded-xl cursor-pointer flex items-center justify-center gap-2 border-dashed transition active:scale-98">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                Cargar Imagen
                            </label>
                            <p class="text-[9px] text-slate-400 mt-1.5 leading-relaxed font-semibold">Carga una foto llamativa para destacar tu anuncio. Tamaño ideal: 800x600px. Máximo 2MB.</p>
                        </div>
                    </div>
                </div>

                <!-- Configuración Botón CTA -->
                <div class="border-t border-slate-100 dark:border-slate-800/80 pt-4 space-y-4">
                    <span class="block text-[10px] font-black text-primary uppercase tracking-widest">Botón de Acción / CTA (Opcional)</span>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="button_text" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Texto del Botón</label>
                            <input type="text" id="button_text" x-model="announcementButtonText" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: ¡Ver Oferta!">
                            <p x-show="errors.button_text" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.button_text"></p>
                        </div>
                        <div>
                            <label for="button_link" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Enlace del Botón</label>
                            <input type="text" id="button_link" x-model="announcementButtonLink" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: https://tutienda.com/producto">
                            <p x-show="errors.button_link" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.button_link"></p>
                        </div>
                    </div>
                </div>

                <!-- Fecha Límite y Estado -->
                <div class="border-t border-slate-100 dark:border-slate-800/80 pt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="expires_at" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Fecha Límite (Expiración)</label>
                        <input type="date" id="expires_at" x-model="announcementExpiresAt" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none focus:border-primary transition">
                        <p class="text-[9px] text-slate-400 mt-1 font-semibold">El anuncio dejará de mostrarse automáticamente después de esta fecha.</p>
                        <p x-show="errors.expires_at" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.expires_at"></p>
                    </div>
                    <div>
                        <label for="is_active" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Estado</label>
                        <select id="is_active" x-model="announcementIsActive" class="select2-enable w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                            <option value="1">Activo / Visible</option>
                            <option value="0">Inactivo / Oculto</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="px-6 py-4 bg-primary flex justify-end gap-3 sticky bottom-0 z-10 shadow-[0_-4px_12px_rgba(0,0,0,0.08)] border-t border-black/10 transition-colors">
                <button type="button" @click="closeModal()" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs px-5 py-3 rounded-xl transition shadow-sm active:scale-95 cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="bg-white hover:bg-white/95 text-primary font-black text-xs px-6 py-3 rounded-xl transition shadow-md active:scale-95 flex items-center gap-2 cursor-pointer">
                    <span x-text="isEdit ? 'Guardar Cambios' : 'Crear Anuncio'">Crear Anuncio</span>
                </button>
            </div>
            </form>
        </div>
    </template>
</div>

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
                                <div class="text-[11px] text-slate-450 dark:text-slate-500 mt-0.5 leading-relaxed font-semibold">${contentText}</div>
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
@endsection
