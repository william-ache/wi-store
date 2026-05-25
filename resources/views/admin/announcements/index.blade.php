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
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <x-admin.excel-toolbar entity="announcements" />
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
      <!-- MODAL DE CREACIÓN / EDICIÓN -->
    @include('modals.announcement')
</div>

@push('scripts')
    @include('partials.announcements.js')
@endpush
@endsection
