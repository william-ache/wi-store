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
    orderDeliveryType: 'delivery',
    orderTableNumber: '',
    orderPaymentReference: '',
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
        this.orderDeliveryType = 'delivery';
        this.orderTableNumber = '';
        this.orderPaymentReference = '';
        this.errors = {};
        this.showModal = true;
    },
    openEdit(id, clientId, name, phone, total, status, method, payStatus, deliveryType, tableNumber, paymentReference) {
        this.isEdit = true;
        this.orderId = id;
        this.orderClientId = clientId || '';
        this.orderCustomerName = name;
        this.orderCustomerPhone = phone;
        this.orderTotal = total;
        this.orderStatus = status;
        this.orderPaymentMethod = method;
        this.orderPaymentStatus = payStatus;
        this.orderDeliveryType = deliveryType || 'delivery';
        this.orderTableNumber = tableNumber || '';
        this.orderPaymentReference = paymentReference || '';
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
                    $('#delivery_type').on('change', (e) => {
                        this.orderDeliveryType = e.target.value;
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
                    $('#delivery_type').val(this.orderDeliveryType).trigger('change.select2');
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
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <x-admin.excel-toolbar entity="orders" />
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
                        <th>Tipo / Mesa</th>
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
    @include('modals.order')
</div>

@push('scripts')
    @include('partials.orders.js')
@endpush
@endsection
