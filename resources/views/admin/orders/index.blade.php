@extends('layouts.admin')

@section('title', 'Gestión de Órdenes')
@section('subtitle', 'Pedidos de tu Menú Digital')
@section('header_title', 'Órdenes de Compra')

@section('content')
<div x-data="{ 
    showModal: false, 
    isEdit: false, 
    orderId: null,
    orderClientId: '',
    orderCustomerName: '',
    orderCustomerPhone: '',
    orderTotal: '',
    orderStatus: 'pending',
    orderPaymentMethod: 'efectivo',
    orderPaymentStatus: 'pending',
    errors: {},
    
    openCreate() {
        this.isEdit = false;
        this.orderId = null;
        this.orderClientId = '';
        this.orderCustomerName = '';
        this.orderCustomerPhone = '';
        this.orderTotal = '';
        this.orderStatus = 'pending';
        this.orderPaymentMethod = 'efectivo';
        this.orderPaymentStatus = 'pending';
        this.errors = {};
        this.showModal = true;
    },
    openEdit(id, clientId, name, phone, total, status, method, payStatus) {
        this.isEdit = true;
        this.orderId = id;
        this.orderClientId = clientId || '';
        this.orderCustomerName = name;
        this.orderCustomerPhone = phone;
        this.orderTotal = total;
        this.orderStatus = status;
        this.orderPaymentMethod = method;
        this.orderPaymentStatus = payStatus;
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
                    // Initialize Select2 for clients (with search)
                    $('#client_id').select2({
                        width: '100%',
                        dropdownParent: $('#orderForm')
                    });

                    // Initialize Select2 for simple selectors (no search)
                    $('.select2-enable').not('#client_id').select2({
                        width: '100%',
                        dropdownParent: $('#orderForm'),
                        minimumResultsForSearch: Infinity
                    });

                    // Bind change events
                    $('#client_id').on('change', (e) => {
                        this.orderClientId = e.target.value;
                        this.syncClientInfo(e.target.value);
                    });
                    $('#payment_method').on('change', (e) => {
                        this.orderPaymentMethod = e.target.value;
                    });
                    $('#status').on('change', (e) => {
                        this.orderStatus = e.target.value;
                    });
                    $('#payment_status').on('change', (e) => {
                        this.orderPaymentStatus = e.target.value;
                    });

                    // Sync Alpine values to Select2 UI on initialization
                    $('#client_id').val(this.orderClientId).trigger('change.select2');
                    $('#payment_method').val(this.orderPaymentMethod).trigger('change.select2');
                    $('#status').val(this.orderStatus).trigger('change.select2');
                    $('#payment_status').val(this.orderPaymentStatus).trigger('change.select2');
                });
            } else {
                $('.select2-enable').select2('destroy');
            }
        });
    },
    syncClientInfo(clientId) {
        if (!clientId) return;
        // Buscar datos del cliente para auto-completar
        $.ajax({
            url: '/{{ config('current_shop')->slug }}/admin/clients/' + clientId,
            type: 'GET',
            success: (response) => {
                if (response.success && response.data) {
                    this.orderCustomerName = response.data.name;
                    this.orderCustomerPhone = response.data.phone;
                }
            }
        });
    }
}" id="orders-page" class="space-y-6">

    <!-- Tarjeta Principal de Control -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] p-6 md:p-8 transition-all duration-300">
        
        <!-- Encabezado de la Sección -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h2 class="text-xl md:text-2xl font-black text-slate-800 dark:text-slate-100 tracking-tight">Registro General de Pedidos</h2>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Administra y haz seguimiento en tiempo real a las compras de tus clientes, cambia el estado de preparación y actualiza el pago.
                </p>
            </div>
            <div>
                <button @click="openCreate()" class="bg-primary hover:bg-primary/90 text-white font-extrabold text-xs px-5 py-3 rounded-xl transition shadow-md hover:shadow-lg shadow-black/5 dark:shadow-black/20 active:scale-95 flex items-center justify-center gap-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Registrar Venta Directa
                </button>
            </div>
        </div>

        <!-- Tabla de Datos con Estilo Moderno -->
        <div class="overflow-x-auto pt-4">
            <table id="ordersTable" class="w-full text-left">
                <thead>
                    <tr>
                        <th>Nº Orden</th>
                        <th>Cliente</th>
                        <th>Teléfono</th>
                        <th>Método Pago</th>
                        <th>Pago</th>
                        <th>Total</th>
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
            <form id="orderForm" @submit.prevent="submitForm($data)"
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
                    <h3 class="text-base md:text-lg font-black text-white mt-0.5" x-text="isEdit ? 'Modificar Orden de Compra' : 'Registrar Venta Directa'">Registrar Venta Directa</h3>
                </div>
                <button type="button" @click="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-all duration-200">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>

            <!-- Formulario (Scrollable Body) -->
            <div class="p-6 space-y-4 overflow-y-auto flex-grow">
                <!-- Vincular a Cliente del Directorio -->
                <div>
                    <label for="client_id" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Asociar a Cliente Registrado (Opcional)</label>
                    <select id="client_id" x-model="orderClientId" @change="syncClientInfo($event.target.value)" class="select2-enable w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                        <option value="">-- Compra Directa sin Cuenta --</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->phone }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nombre y Teléfono en Fila -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="customer_name" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Nombre del Cliente</label>
                        <input type="text" id="customer_name" x-model="orderCustomerName" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: Aníbal Peralta">
                        <p x-show="errors.customer_name" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.customer_name"></p>
                    </div>
                    <div>
                        <label for="customer_phone" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Teléfono del Cliente</label>
                        <input type="text" id="customer_phone" x-model="orderCustomerPhone" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: +58 412-5551234">
                        <p x-show="errors.customer_phone" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.customer_phone"></p>
                    </div>
                </div>

                <!-- Total de la Orden y Método de Pago -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="total" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Monto Total ($)</label>
                        <input type="number" step="0.01" id="total" x-model="orderTotal" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: 25.00">
                        <p x-show="errors.total" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.total"></p>
                    </div>
                    <div>
                        <label for="payment_method" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Método de Pago</label>
                        <select id="payment_method" x-model="orderPaymentMethod" class="select2-enable w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                            <option value="efectivo">Efectivo ($ / Bs)</option>
                            <option value="pagomovil">Pago Móvil</option>
                            <option value="zelle">Zelle</option>
                            <option value="tarjeta">Tarjeta de Crédito / Débito</option>
                        </select>
                    </div>
                </div>

                <!-- Estado del Pedido y Estado del Pago -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Estado del Pedido</label>
                        <select id="status" x-model="orderStatus" class="select2-enable w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                            <option value="pending">Pendiente por Confirmar</option>
                            <option value="preparing">En Preparación</option>
                            <option value="delivered">Entregado / Despachado</option>
                            <option value="cancelled">Cancelado</option>
                        </select>
                    </div>
                    <div>
                        <label for="payment_status" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Estado del Pago</label>
                        <select id="payment_status" x-model="orderPaymentStatus" class="select2-enable w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                            <option value="pending">Pendiente por Cobrar</option>
                            <option value="paid">Pagado y Conciliado</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción (Footer Sticky con color primario) -->
            <div class="px-6 py-4 bg-primary flex justify-end gap-3 sticky bottom-0 z-10 shadow-[0_-4px_12px_rgba(0,0,0,0.08)] border-t border-black/10 transition-colors">
                <button type="button" @click="closeModal()" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs px-5 py-3 rounded-xl transition shadow-sm active:scale-95">
                    Cancelar
                </button>
                <button type="submit" class="bg-white hover:bg-white/95 text-primary font-black text-xs px-6 py-3 rounded-xl transition shadow-md active:scale-95 flex items-center gap-2">
                    <span x-text="isEdit ? 'Guardar Cambios' : 'Confirmar Pedido'">Confirmar Pedido</span>
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
        datatable = $('#ordersTable').DataTable({
            processing: true,
            ajax: {
                url: window.location.pathname,
                dataSrc: 'data'
            },
            columns: [
                { 
                    data: 'order_number',
                    render: function(data) {
                        return `<span class="bg-slate-100 dark:bg-slate-800 text-[11px] font-black px-2.5 py-1 rounded-lg text-slate-700 dark:text-slate-300 border border-slate-200/20">${data}</span>`;
                    }
                },
                { 
                    data: 'customer_name',
                    render: function(data, type, row) {
                        const direct = row.client_id ? '' : ' <span class="bg-slate-100 dark:bg-slate-800 text-slate-400 text-[8px] uppercase font-bold px-1.5 py-0.5 rounded ml-1">Directo</span>';
                        return `<div class="font-bold text-slate-800 dark:text-slate-200 flex items-center">${data}${direct}</div>`;
                    }
                },
                { 
                    data: 'customer_phone',
                    render: function(data) {
                        return `<span class="text-xs text-slate-600 dark:text-slate-300 font-semibold">${data}</span>`;
                    }
                },
                { 
                    data: 'payment_method',
                    render: function(data) {
                        const map = {
                            'efectivo': 'Efectivo',
                            'pagomovil': 'Pago Móvil',
                            'zelle': 'Zelle',
                            'tarjeta': 'Tarjeta'
                        };
                        return `<span class="text-xs font-bold text-slate-700 dark:text-slate-300">${map[data] || data}</span>`;
                    }
                },
                { 
                    data: 'payment_status',
                    render: function(data) {
                        if (data === 'paid') {
                            return `<span class="bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 text-[9px] font-black px-2 py-0.5 rounded border border-emerald-200/20">PAGADO</span>`;
                        } else {
                            return `<span class="bg-amber-100 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 text-[9px] font-black px-2 py-0.5 rounded border border-amber-200/20">PENDIENTE</span>`;
                        }
                    }
                },
                { 
                    data: 'total',
                    render: function(data) {
                        return `<div class="font-black text-slate-800 dark:text-slate-100">$${parseFloat(data).toFixed(2)}</div>`;
                    }
                },
                { 
                    data: 'status',
                    render: function(data) {
                        const classes = {
                            'pending': 'bg-amber-100 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 border-amber-200/30',
                            'preparing': 'bg-blue-100 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 border-blue-200/30',
                            'delivered': 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border-emerald-200/30',
                            'cancelled': 'bg-rose-100 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 border-rose-200/30'
                        };
                        const labels = {
                            'pending': 'Pendiente',
                            'preparing': 'En Preparación',
                            'delivered': 'Entregado',
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
                        return `
                            <div class="flex items-center gap-2">
                                <button onclick="editOrder(${row.id}, ${row.client_id || 'null'}, '${row.customer_name.replace(/'/g, "\\'")}', '${row.customer_phone}', ${row.total}, '${row.status}', '${row.payment_method}', '${row.payment_status}')" class="p-2 bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700 hover:border-primary rounded-xl text-slate-600 dark:text-slate-400 hover:text-primary transition-all shadow-sm cursor-pointer" title="Editar">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>
                                <button onclick="deleteOrder(${row.id})" class="p-2 bg-rose-50 dark:bg-rose-950/30 border border-rose-100/40 hover:border-rose-500 rounded-xl text-rose-600 dark:text-rose-400 hover:text-white hover:bg-rose-500 transition-all shadow-sm cursor-pointer" title="Eliminar">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            language: {
                processing: "Cargando órdenes...",
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
                emptyTable: "No se encontraron órdenes registradas en tu menú digital."
            },
            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4"l<"flex items-center gap-3"Bf>>t<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-4"ip>',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<span class="flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> Excel</span>',
                    className: 'btn-export-excel',
                    titleAttr: 'Exportar a Excel',
                    filename: function() {
                        return ('Reporte_Ordenes_{{ config('current_shop')->slug }}').replace(/[\r\n\t]/g, '').replace(/[^a-zA-Z0-9_-]/g, '_').trim();
                    },
                    title: function() {
                        return ('Reporte de Órdenes - {{ config('current_shop')->name }}').replace(/[\r\n\t]/g, '').trim();
                    },
                    messageTop: function() {
                        let dt = $('#ordersTable').DataTable();
                        let total = dt.rows({ search: 'applied' }).count();
                        let date = new Date().toLocaleDateString('es-ES');
                        return 'Reporte: Órdenes | Generado el: ' + date + ' | Total Registros: ' + total;
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
    function editOrder(id, clientId, name, phone, total, status, method, payStatus) {
        Alpine.$data(document.getElementById('orders-page')).openEdit(id, clientId, name, phone, total, status, method, payStatus);
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
        let url = '/{{ config('current_shop')->slug }}/admin/orders';
        let method = 'POST';

        if (alpineData.isEdit) {
            url += '/' + alpineData.orderId;
            method = 'PUT';
        }

        $.ajax({
            url: url,
            type: method,
            data: {
                _token: '{{ csrf_token() }}',
                client_id: alpineData.orderClientId,
                customer_name: alpineData.orderCustomerName,
                customer_phone: alpineData.orderCustomerPhone,
                total: alpineData.orderTotal,
                status: alpineData.orderStatus,
                payment_method: alpineData.orderPaymentMethod,
                payment_status: alpineData.orderPaymentStatus
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

    // Eliminar Orden
    function deleteOrder(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer y eliminará el registro de la orden.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/{{ config('current_shop')->slug }}/admin/orders/' + id,
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
                            title: 'Ocurrió un error al intentar eliminar la orden.'
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
                url: `/{{ config('current_shop')->slug }}/admin/orders/${editId}`,
                type: 'GET',
                success: function(res) {
                    if (res.success && res.data) {
                        editOrder(res.data.id, res.data.client_id, res.data.customer_name, res.data.customer_phone, res.data.total, res.data.status, res.data.payment_method, res.data.payment_status);
                        window.history.replaceState({}, document.title, window.location.pathname);
                    }
                }
            });
        }
    });
</script>
@endsection
