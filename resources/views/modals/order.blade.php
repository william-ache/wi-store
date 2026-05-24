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

            <!-- Tipo de Pedido y Número de Mesa (Dine-in) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="delivery_type" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Tipo de Pedido</label>
                    <select id="delivery_type" x-model="orderDeliveryType" class="select2-enable w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition">
                        <option value="delivery">Delivery</option>
                        <option value="pickup">Retiro en Local</option>
                        <option value="dine_in">Consumo en Mesa (Dine-in)</option>
                    </select>
                </div>
                <div x-show="orderDeliveryType === 'dine_in'" x-transition>
                    <label for="table_number" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Número de Mesa</label>
                    <input type="number" id="table_number" x-model="orderTableNumber" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl px-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: 4">
                    <p x-show="errors.table_number" class="text-[10px] text-rose-500 font-bold mt-1" x-text="errors.table_number"></p>
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

            <!-- Referencia de Pago (Si existe, para conciliar) -->
            <div class="space-y-1.5">
                <label for="payment_reference" class="block text-[10px] font-black text-primary uppercase tracking-widest mb-1.5">Referencia de Pago / Gateway</label>
                <div class="relative flex items-center">
                    <span class="absolute left-3.5 text-slate-400 text-xs"><i class="fas fa-receipt"></i></span>
                    <input type="text" id="payment_reference" x-model="orderPaymentReference" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-xs font-semibold rounded-xl pl-9 pr-4 py-3 focus:outline-none focus:border-primary transition" placeholder="Ej: STRIPE-ABC123XYZ, PM-1234">
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
