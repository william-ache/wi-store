@extends('layouts.admin')

@section('title', 'Gestión de Reservas')
@section('subtitle', 'Citas y Reservaciones de tu Catálogo')
@section('header_title', 'Reservas de Clientes')

@section('content')
<div x-data="{ 
    showModal: false, 
    isEdit: false, 
    bookingId: null,
    bookingName: '',
    bookingPhone: '',
    bookingDate: '',
    bookingTimeSlot: '',
    bookingStatus: 'pending',
    errors: {},
    
    openCreate() {
        this.isEdit = false;
        this.bookingId = null;
        this.bookingName = '';
        this.bookingPhone = '';
        this.bookingDate = new Date().toISOString().split('T')[0];
        this.bookingTimeSlot = '12:00 - 13:00';
        this.bookingStatus = 'pending';
        this.errors = {};
        this.showModal = true;
    },
    openEdit(id, name, phone, date, slot, status) {
        this.isEdit = true;
        this.bookingId = id;
        this.bookingName = name;
        this.bookingPhone = phone;
        this.bookingDate = date;
        this.bookingTimeSlot = slot;
        this.bookingStatus = status;
        this.errors = {};
        this.showModal = true;
    },
    closeModal() {
        this.showModal = false;
        this.errors = {};
    }
}" id="bookings-page" class="space-y-6">

    <!-- Tarjeta Principal de Control -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] p-6 md:p-8 transition-all duration-300">
        
        <!-- Encabezado de la Sección -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h2 class="text-xl md:text-2xl font-black text-slate-800 dark:text-slate-100 tracking-tight">Registro de Citas y Reservas</h2>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Gestiona las solicitudes de tus clientes, confirma su asistencia, bloquea horarios y mantén al día tu agenda.
                </p>
            </div>
            <div>
                <button @click="openCreate()" class="bg-primary hover:bg-primary/90 text-white font-extrabold text-xs px-5 py-3 rounded-xl transition shadow-md hover:shadow-lg shadow-black/5 dark:shadow-black/20 active:scale-95 flex items-center justify-center gap-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Crear Reserva Manual
                </button>
            </div>
        </div>

        <!-- Tabla de Datos -->
        <div class="overflow-x-auto pt-4">
            <table id="bookingsTable" class="w-full text-left">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Cliente</th>
                        <th>Teléfono</th>
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
            <form id="bookingForm" @submit.prevent="submitForm($data)"
             x-show="showModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white dark:bg-slate-900 rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col transition-colors duration-300 max-h-[90vh]">
            
            <!-- Header -->
            <div class="px-6 py-5 border-b border-black/10 dark:border-white/10 flex items-center justify-between sticky top-0 z-10 bg-primary text-white transition-colors duration-300 shadow-md">
                <div>
                    <span class="text-[9px] uppercase font-extrabold tracking-widest text-white/70" x-text="isEdit ? 'Editar Reserva' : 'Nueva Reserva'">Nueva Reserva</span>
                    <h3 class="text-base md:text-lg font-black text-white mt-0.5" x-text="isEdit ? 'Modificar Datos de Reserva' : 'Registrar Nueva Reserva'">Registrar Nueva Reserva</h3>
                </div>
                <button type="button" @click="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-all duration-200">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>

            <!-- Form Body -->
            <div class="p-6 space-y-4 overflow-y-auto flex-grow">
                <!-- Nombre del Cliente -->
                <div>
                    <label for="booking_name" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Nombre Completo del Cliente</label>
                    <input type="text" id="booking_name" x-model="bookingName" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: Valentina Ramos" required>
                    <p x-show="errors.client_name" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.client_name"></p>
                </div>

                <!-- Teléfono del Cliente -->
                <div>
                    <label for="booking_phone" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Teléfono / WhatsApp</label>
                    <input type="text" id="booking_phone" x-model="bookingPhone" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: +58 412-1234567" required>
                    <p x-show="errors.client_phone" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.client_phone"></p>
                </div>

                <!-- Fecha y Horario en Fila -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="booking_date" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Fecha de la Cita</label>
                        <input type="date" id="booking_date" x-model="bookingDate" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" required>
                        <p x-show="errors.date" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.date"></p>
                    </div>
                    <div>
                        <label for="booking_slot" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Bloque de Horario</label>
                        <select id="booking_slot" x-model="bookingTimeSlot" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                            <option value="08:00 - 09:00">08:00 AM - 09:00 AM</option>
                            <option value="09:00 - 10:00">09:00 AM - 10:00 AM</option>
                            <option value="10:00 - 11:00">10:00 AM - 11:00 AM</option>
                            <option value="11:00 - 12:00">11:00 AM - 12:00 PM</option>
                            <option value="12:00 - 13:00">12:00 PM - 01:00 PM</option>
                            <option value="13:00 - 14:00">01:00 PM - 02:00 PM</option>
                            <option value="14:00 - 15:00">02:00 PM - 03:00 PM</option>
                            <option value="15:00 - 16:00">03:00 PM - 04:00 PM</option>
                            <option value="16:00 - 17:00">04:00 PM - 05:00 PM</option>
                            <option value="17:00 - 18:00">05:00 PM - 06:00 PM</option>
                            <option value="18:00 - 19:00">06:00 PM - 07:00 PM</option>
                            <option value="19:00 - 20:00">07:00 PM - 08:00 PM</option>
                        </select>
                        <p x-show="errors.time_slot" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.time_slot"></p>
                    </div>
                </div>

                <!-- Estado de la Reserva -->
                <div>
                    <label for="booking_status" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Estado de Reservación</label>
                    <select id="booking_status" x-model="bookingStatus" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                        <option value="pending">Pendiente por Confirmar</option>
                        <option value="confirmed">Confirmada / Aprobada</option>
                        <option value="cancelled">Cancelada / Rechazada</option>
                    </select>
                    <p x-show="errors.status" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.status"></p>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-primary flex justify-end gap-3 sticky bottom-0 z-10 shadow-[0_-4px_12px_rgba(0,0,0,0.08)] border-t border-black/10 transition-colors">
                <button type="button" @click="closeModal()" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs px-5 py-3 rounded-xl transition shadow-sm active:scale-95">
                    Cancelar
                </button>
                <button type="submit" class="bg-white hover:bg-white/95 text-primary font-black text-xs px-6 py-3 rounded-xl transition shadow-md active:scale-95 flex items-center gap-2">
                    <span x-text="isEdit ? 'Guardar Cambios' : 'Confirmar Cita'">Confirmar Cita</span>
                </button>
            </div>
            </form>
        </div>
    </template>
</div>

@push('scripts')
<script>
    let datatable;

    $(document).ready(function() {
        // Inicializar DataTable
        datatable = $('#bookingsTable').DataTable({
            processing: true,
            ajax: {
                url: window.location.pathname,
                dataSrc: 'data'
            },
            columns: [
                { 
                    data: 'date',
                    render: function(data) {
                        if (!data) return '';
                        let d = new Date(data);
                        let offset = d.getTimezoneOffset() * 60000;
                        let localDate = new Date(d.getTime() + offset);
                        return `<span class="text-xs text-slate-800 dark:text-slate-200 font-extrabold flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> ${localDate.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' })}</span>`;
                    }
                },
                { 
                    data: 'time_slot',
                    render: function(data) {
                        return `<span class="bg-slate-50 dark:bg-slate-800 text-[10px] font-black px-2 py-1 rounded-lg text-slate-700 dark:text-slate-300 border border-slate-200/40">${data}</span>`;
                    }
                },
                { 
                    data: 'client_name',
                    render: function(data) {
                        return `<div class="font-bold text-slate-800 dark:text-slate-200">${data}</div>`;
                    }
                },
                { 
                    data: 'client_phone',
                    render: function(data) {
                        return `<span class="text-xs text-slate-600 dark:text-slate-300 font-semibold">${data}</span>`;
                    }
                },
                { 
                    data: 'status',
                    render: function(data) {
                        const classes = {
                            'pending': 'bg-amber-100 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 border-amber-200/30',
                            'confirmed': 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border-emerald-200/30',
                            'cancelled': 'bg-rose-100 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 border-rose-200/30'
                        };
                        const labels = {
                            'pending': 'Pendiente',
                            'confirmed': 'Confirmado',
                            'cancelled': 'Cancelado'
                        };
                        return `<span class="${classes[data] || 'bg-slate-100 text-slate-600'} text-[10px] font-black px-2.5 py-1 rounded-full border">${labels[data] || data}</span>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        // Formatear fecha para JS
                        let rawDate = row.date.split('T')[0];
                        return `
                            <div class="flex items-center gap-2">
                                <button onclick="editBooking(${row.id}, '${row.client_name.replace(/'/g, "\\'")}', '${row.client_phone}', '${rawDate}', '${row.time_slot}', '${row.status}')" class="p-2 bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700 hover:border-primary rounded-xl text-slate-600 dark:text-slate-400 hover:text-primary transition-all shadow-sm cursor-pointer" title="Editar">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>
                                <button onclick="deleteBooking(${row.id})" class="p-2 bg-rose-50 dark:bg-rose-950/30 border border-rose-100/40 hover:border-rose-500 rounded-xl text-rose-600 dark:text-rose-400 hover:text-white hover:bg-rose-500 transition-all shadow-sm cursor-pointer" title="Eliminar">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            language: {
                processing: "Cargando agenda...",
                search: "",
                searchPlaceholder: "Buscar reserva...",
                lengthMenu: "Mostrar _MENU_ citas",
                info: "Mostrando _START_ a _END_ de _TOTAL_ citas",
                infoEmpty: "Mostrando 0 citas",
                infoFiltered: "(filtrado de _MAX_ citas totales)",
                paginate: {
                    first: "Primero",
                    previous: "‹",
                    next: "›",
                    last: "Último"
                },
                emptyTable: "No tienes solicitudes de reservas agendadas en tu menú digital."
            },
            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4"l<"flex items-center gap-3"Bf>>t<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-4"ip>',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<span class="flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> Excel</span>',
                    className: 'btn-export-excel',
                    titleAttr: 'Exportar a Excel',
                    filename: 'Reporte_Reservas_{{ config('current_shop')->slug }}',
                    title: 'Reporte de Reservaciones - {{ config('current_shop')->name }}',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }
            ]
        });
    });

    // Delegación
    function editBooking(id, name, phone, date, slot, status) {
        Alpine.$data(document.getElementById('bookings-page')).openEdit(id, name, phone, date, slot, status);
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    // Submit Form
    function submitForm(alpineData) {
        let url = '/{{ config('current_shop')->slug }}/admin/bookings';
        let method = 'POST';

        if (alpineData.isEdit) {
            url += '/' + alpineData.bookingId;
            method = 'PUT';
        }

        $.ajax({
            url: url,
            type: method,
            data: {
                _token: '{{ csrf_token() }}',
                client_name: alpineData.bookingName,
                client_phone: alpineData.bookingPhone,
                date: alpineData.bookingDate,
                time_slot: alpineData.bookingTimeSlot,
                status: alpineData.bookingStatus
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
                        title: 'Ocurrió un error inesperado al agendar la reserva.'
                    });
                }
            }
        });
    }

    // Eliminar Reserva
    function deleteBooking(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer y cancelará la cita definitivamente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cancelar cita',
            cancelButtonText: 'Cerrar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/{{ config('current_shop')->slug }}/admin/bookings/' + id,
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
                            title: 'Ocurrió un error al intentar cancelar la cita.'
                        });
                    }
                });
            }
        });
    }
</script>
@endpush
