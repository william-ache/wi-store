@extends('layouts.admin')

@section('title', 'Carritos Abandonados')
@section('subtitle', 'Telemetría de Ventas Pendientes')
@section('header_title', 'Carritos Abandonados')

@section('content')
<div id="abandoned-carts-page" class="space-y-6">

    <!-- Tarjeta Principal de Control -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] p-6 md:p-8 transition-all duration-300">
        
        <!-- Encabezado de la Sección -->
        <div class="pb-6 border-b border-slate-100 dark:border-slate-800">
            <h2 class="text-xl md:text-2xl font-black text-slate-800 dark:text-slate-100 tracking-tight">Recuperación de Ventas Perdidas</h2>
            <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Visualiza los carritos de clientes que iniciaron el ingreso de datos pero no finalizaron la orden. ¡Recupéralos con un mensaje directo de WhatsApp!
            </p>
        </div>

        <!-- Tabla de Datos -->
        <div class="overflow-x-auto pt-4">
            <table id="abandonedCartsTable" class="w-full text-left">
                <thead>
                    <tr>
                        <th>Fecha de Abandono</th>
                        <th>Cliente</th>
                        <th>Teléfono</th>
                        <th>Productos Interesados</th>
                        <th>Valor Estimado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Poblado via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let datatable;

    $(document).ready(function() {
        // Inicializar DataTable
        datatable = $('#abandonedCartsTable').DataTable({
            processing: true,
            ajax: {
                url: window.location.pathname,
                dataSrc: 'data'
            },
            columns: [
                { 
                    data: 'updated_at',
                    render: function(data) {
                        if (!data) return '';
                        let d = new Date(data);
                        return `<span class="text-xs text-slate-800 dark:text-slate-200 font-extrabold flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> ${d.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</span>`;
                    }
                },
                { 
                    data: 'customer_name',
                    render: function(data) {
                        return `<div class="font-bold text-slate-800 dark:text-slate-200">${data}</div>`;
                    }
                },
                { 
                    data: 'customer_phone',
                    render: function(data) {
                        return `<span class="text-xs text-slate-600 dark:text-slate-300 font-semibold">${data}</span>`;
                    }
                },
                { 
                    data: 'cart_data',
                    render: function(data) {
                        if (!data || !Array.isArray(data)) return '';
                        return data.map(item => {
                            return `<span class="inline-flex items-center gap-1 bg-slate-100 dark:bg-slate-800 text-[10px] text-slate-600 dark:text-slate-300 font-black px-2 py-0.5 rounded-lg border border-slate-200/40 mb-1 mr-1">${item.quantity}x ${item.name}</span>`;
                        }).join('');
                    }
                },
                { 
                    data: 'cart_data',
                    render: function(data) {
                        if (!data || !Array.isArray(data)) return '$0.00';
                        let sum = data.reduce((acc, item) => acc + (parseFloat(item.price) * parseInt(item.quantity)), 0);
                        return `<div class="font-black text-emerald-600 dark:text-emerald-400">$${sum.toFixed(2)}</div>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <div class="flex items-center gap-2">
                                <button onclick="recoverCart('${row.customer_phone}', '${row.customer_name.replace(/'/g, "\\'")}', ${JSON.stringify(row.cart_data).replace(/"/g, '&quot;')})" class="flex items-center gap-1 text-[11px] bg-emerald-50 hover:bg-emerald-500 hover:text-white border border-emerald-100 hover:border-emerald-500 text-emerald-600 font-black px-3 py-1.5 rounded-xl transition cursor-pointer shadow-sm active:scale-95" title="Recuperar por WhatsApp">
                                    <i class="fab fa-whatsapp text-xs"></i> Recuperar
                                </button>
                                <button onclick="deleteCart(${row.id})" class="p-2 bg-rose-50 dark:bg-rose-950/30 border border-rose-100/40 hover:border-rose-500 rounded-xl text-rose-600 dark:text-rose-400 hover:text-white hover:bg-rose-500 transition-all shadow-sm cursor-pointer" title="Eliminar">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            language: {
                processing: "Cargando telemetría...",
                search: "",
                searchPlaceholder: "Buscar carrito...",
                lengthMenu: "Mostrar _MENU_ carritos",
                info: "Mostrando _START_ a _END_ de _TOTAL_ carritos",
                infoEmpty: "Mostrando 0 carritos",
                infoFiltered: "(filtrado de _MAX_ carritos totales)",
                paginate: {
                    first: "Primero",
                    previous: "‹",
                    next: "›",
                    last: "Último"
                },
                emptyTable: "No se registran carritos abandonados recientemente en tu menú digital."
            },
            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4"l<"flex items-center gap-3"Bf>>t<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-4"ip>',
            buttons: []
        });
    });

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    // Enviar recordatorio de WhatsApp
    function recoverCart(phone, name, cartData) {
        let shopName = '{{ config('current_shop')->name }}';
        let shopUrl = '{{ request()->getSchemeAndHttpHost() . '/' . config('current_shop')->slug }}';
        
        let text = `*¡Hola ${name}!* 👋%0A%0A`;
        text += `Notamos que dejaste algunos artículos en tu carrito de *${shopName}* y queremos ayudarte a completar tu pedido. 🛍️%0A%0A`;
        text += `*Artículos pendientes:*%0A`;
        
        cartData.forEach(item => {
            text += `▫️ ${item.quantity}x ${item.name} - $${(parseFloat(item.price) * parseInt(item.quantity)).toFixed(2)}%0A`;
        });
        
        text += `%0A👉 Completa tu pedido de forma fácil haciendo clic aquí: ${shopUrl}%0A%0A`;
        text += `Si tienes alguna duda o deseas modificar algo, ¡escríbenos por aquí! Nos encantaría atenderte. ❤️`;

        let url = `https://api.whatsapp.com/send?phone=${phone.replace(/[^0-9]/g, '')}&text=${text}`;
        window.open(url, '_blank');
    }

    // Eliminar telemetría
    function deleteCart(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción removerá el registro de carrito abandonado definitivamente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, remover',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/{{ config('current_shop')->slug }}/admin/abandoned-carts/' + id,
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
                            title: 'Ocurrió un error al intentar eliminar el registro.'
                        });
                    }
                });
            }
        });
    }
</script>
@endpush
