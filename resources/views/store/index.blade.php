<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $company['name'] }} - Menú Digital</title>
    
    <!-- Tailwind CSS & Lucide Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js Plugins & Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- Estilos de Colores Dinámicos -->
    <style>
        :root {
            --color-primary: {{ $company['colors']['primary'] }};
            --color-secondary: {{ $company['colors']['secondary'] }};
            --color-bg: {{ $company['colors']['bg_light'] }};
        }
        body {
            font-family: 'Outfit', 'sans-serif';
            background: linear-gradient(135deg, var(--color-bg) 0%, rgba(255, 255, 255, 0.4) 100%);
            -webkit-tap-highlight-color: transparent;
        }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="min-h-screen text-slate-800 pb-16 md:pb-6 select-none" x-data="storeApp()">

    <!-- Barra Flotante de Retorno a WIStore (Solo Desktop) -->
    <div class="hidden md:block fixed top-4 left-4 z-[9999]">
        <a href="/" class="flex items-center gap-2 bg-slate-900/95 backdrop-blur-md text-white text-xs font-bold px-4 py-2.5 rounded-full border border-slate-800/80 shadow-2xl hover:bg-slate-800 transition active:scale-95">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Volver a WIStore</span>
        </a>
    </div>

    <!-- LOADER ESTÉTICO DE 3 SEGUNDOS -->
    <div id="app-loader" class="fixed inset-0 bg-white flex flex-col justify-center items-center z-[9999] transition-opacity duration-500">
        <div class="w-14 h-14 border-4 border-slate-100 rounded-full animate-spin" style="border-top-color: var(--color-primary);"></div>
        <span class="mt-4 text-xs font-semibold tracking-wider text-slate-400 uppercase">Cargando Menú...</span>
    </div>

    <!-- 1. MÓVIL: PORTADA DE TIENDA -->
    <div class="md:hidden relative h-48 w-full bg-slate-900 overflow-hidden shadow-inner">
        <img src="{{ $company['cover'] }}" alt="Portada" class="w-full h-full object-cover opacity-80">
        <div class="absolute top-4 left-4 right-4 flex justify-between items-center z-10">
            <a href="/" class="w-10 h-10 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center shadow-md active:scale-95 transition">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-slate-800"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </a>
            <button @click="scrollToReviews()" class="w-10 h-10 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center shadow-md active:scale-95 transition">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="text-yellow-500"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            </button>
        </div>
    </div>

    <!-- LAYOUT MÓVIL / ESCRITORIO HÍBRIDO INTELIGENTE -->
    <div class="max-w-7xl mx-auto px-4 md:px-8 pt-4 md:pt-12">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <!-- A. COLUMNA IZQUIERDA (Fija en Escritorio, Flotante en Móvil) -->
            <!-- MD: 4 COLUMNAS DE ANCHO -->
            <div class="md:col-span-4 lg:col-span-3 md:sticky md:top-6 space-y-6">
                <!-- Tarjeta Comercial (Móvil -mt-16, Escritorio mt-0) -->
                <div class="relative bg-white/90 backdrop-blur-md border border-white/50 rounded-3xl p-6 shadow-xl text-center -mt-16 md:mt-0 z-20 md:z-auto">
                    <!-- Logo Flotante -->
                    <div class="absolute -top-12 md:-top-10 left-1/2 -translate-x-1/2 w-24 h-24 rounded-full border-4 border-white bg-white shadow-lg overflow-hidden">
                        <img src="{{ $company['logo'] }}" alt="Logo" class="w-full h-full object-cover">
                    </div>

                    <!-- Datos Comerciales -->
                    <div class="pt-12">
                        <h1 class="text-xl md:text-2xl font-black tracking-tight" style="color: var(--color-secondary);">
                            {{ $company['name'] }}
                        </h1>
                        <p class="text-xs text-slate-400 mt-1 flex items-center justify-center gap-1">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            {{ $company['address'] }}
                        </p>

                        <!-- Medallas Estatus -->
                        <div class="flex items-center justify-center gap-2 mt-4 text-[10px] md:text-xs font-semibold">
                            <span class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full border border-emerald-100 flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                                Abierto
                            </span>
                            <span class="bg-amber-50 text-amber-600 px-3 py-1 rounded-full border border-amber-100 flex items-center gap-1">
                                ⭐ {{ number_format($averageRating, 1) }}
                            </span>
                        </div>

                        <p class="text-sm text-slate-500 mt-4 leading-relaxed">
                            {{ $company['description'] ?: '¡Haz tu pedido en línea de forma rápida y sencilla!' }}
                        </p>

                        <!-- Métodos de Pago en Escritorio -->
                        <div class="hidden md:block mt-6 text-left border-t border-slate-100 pt-4">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Métodos de Pago</h4>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach(explode(',', $company['payment_methods'] ?: 'Pago Móvil,Efectivo') as $method)
                                    <span class="bg-slate-50 text-slate-600 text-[10px] font-bold px-2.5 py-1 rounded border border-slate-200/60">{{ trim($method) }}</span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tasa de Cambio BCV -->
                        <div class="mt-5 w-full bg-[#fff8e6] border border-[#ffe199] rounded-2xl px-4 py-2.5 flex flex-col items-center">
                            <span class="text-amber-800 text-[10px] font-extrabold uppercase tracking-wide">Tasa BCV Oficial</span>
                            <span class="text-base font-black text-amber-950 mt-0.5">{{ $company['exchange_rate'] }}</span>
                            <span class="text-[9px] text-amber-700/80">Act: {{ $company['exchange_updated_at'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- BARRALATERAL DE CATEGORÍAS EN ESCRITORIO -->
                <div class="hidden md:block bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-1">
                    <h3 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider px-3 mb-3">Categorías</h3>
                    @foreach($categories as $category)
                        @if($category->products->count() > 0)
                        <a href="#cat-{{ $category->id }}" 
                           class="flex items-center justify-between p-3 rounded-2xl font-bold text-xs transition duration-200 border"
                           :class="activeCategory === {{ $category->id }} 
                                ? 'bg-[var(--color-primary)] border-[var(--color-primary)] text-white shadow-md shadow-brand-500/10' 
                                : 'bg-transparent border-transparent text-slate-500 hover:bg-slate-50 hover:text-slate-800'"
                           @click="activeCategory = {{ $category->id }}">
                            {{ $category->name }}
                            <span class="text-[10px] px-2 py-0.5 rounded-full" 
                                  :class="activeCategory === {{ $category->id }} ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-400'">
                                {{ $category->products->count() }}
                            </span>
                        </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- B. COLUMNA CENTRAL: PRODUCTOS (Híbrida) -->
            <!-- MD: 8 COLUMNAS DE ANCHO (O 6 SI EL CARRITO DE ESCRITORIO ESTÁ AL LADO) -->
            <div class="md:col-span-8 lg:col-span-6 space-y-8">
                <!-- MÓVIL: NAVEGACIÓN DE CATEGORÍAS EN PILL (md:hidden) -->
                <div class="md:hidden sticky top-0 bg-white/90 backdrop-blur-md border-b border-slate-100 py-3.5 z-40 mt-4 shadow-sm -mx-4 px-4 overflow-x-auto flex items-center gap-2 whitespace-nowrap scrollbar-none">
                    @foreach($categories as $category)
                        @if($category->products->count() > 0)
                        <a href="#cat-{{ $category->id }}" 
                           class="px-4 py-2 rounded-full text-xs font-bold transition duration-200 border"
                           :class="activeCategory === {{ $category->id }} 
                                ? 'bg-[var(--color-primary)] border-[var(--color-primary)] text-white shadow-sm' 
                                : 'bg-white border-slate-200 text-slate-500'"
                           @click="activeCategory = {{ $category->id }}">
                            {{ $category->name }}
                        </a>
                        @endif
                    @endforeach
                </div>

                <!-- LISTADO PRODUCTOS -->
                <div>
                    @foreach($categories as $category)
                        @if($category->products->count() > 0)
                        <section id="cat-{{ $category->id }}" class="mb-12 scroll-margin-top-[80px]" x-intersect="activeCategory = {{ $category->id }}">
                            <div class="flex items-center gap-2.5 mb-6">
                                <span class="w-1.5 h-6 rounded-full" style="background-color: var(--color-primary);"></span>
                                <h2 class="text-lg font-black tracking-tight" style="color: var(--color-secondary);">{{ $category->name }}</h2>
                            </div>

                            <!-- Grid 2 Columnas Móvil, 3 Columnas Escritorio -->
                            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($category->products as $product)
                                <div class="bg-white border border-slate-100 rounded-3xl p-3 shadow-sm flex flex-col justify-between relative overflow-hidden group">
                                    @if($product->image_path)
                                    <div class="h-32 w-full rounded-2xl overflow-hidden mb-3 bg-slate-50">
                                        <img src="{{ filter_var($product->image_path, FILTER_VALIDATE_URL) ? $product->image_path : asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    </div>
                                    @endif

                                    <div class="flex-grow flex flex-col justify-between">
                                        <div>
                                            <h3 class="text-xs md:text-sm font-bold text-slate-800 line-clamp-1 mb-1">{{ $product->name }}</h3>
                                            <p class="text-[10px] text-slate-400 line-clamp-2 leading-relaxed mb-3">{{ $product->description }}</p>
                                        </div>
                                        
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-sm md:text-base font-extrabold text-slate-900">${{ number_format($product->price, 2) }}</span>
                                            <button class="w-8 h-8 rounded-full text-white flex items-center justify-center shadow active:scale-90 transition"
                                                    style="background-color: var(--color-primary);"
                                                    @click="addToCart({{ $product->toJson() }})">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </section>
                        @endif
                    @endforeach
                </div>

                <!-- OPINIONES DE CLIENTES -->
                <section id="reviews-section" class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                    <div class="flex items-center gap-2 mb-6">
                        <span class="w-1.5 h-6 rounded-full" style="background-color: var(--color-primary);"></span>
                        <h2 class="text-lg font-black tracking-tight" style="color: var(--color-secondary);">Opiniones de Clientes</h2>
                    </div>

                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 mb-6">
                        <h3 class="text-xs font-bold mb-3">Deja tu opinión</h3>
                        <div x-show="reviewSubmitted" class="bg-emerald-50 text-emerald-700 text-xs font-semibold p-3.5 rounded-2xl border border-emerald-100 mb-3">¡Calificación recibida!</div>
                        <form @submit.prevent="submitReview" x-show="!reviewSubmitted" class="flex flex-col gap-3">
                            <input type="text" x-model="review.name" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brand-500" placeholder="Nombre" required>
                            <div class="flex items-center justify-between bg-white border border-slate-200 rounded-xl px-4 py-2">
                                <span class="text-xs font-bold text-slate-500">Valoración:</span>
                                <div class="flex gap-1 flex-row-reverse">
                                    <input type="radio" id="star5" name="rating" value="5" x-model="review.rating" class="hidden" required/><label for="star5" class="text-xl text-slate-200 cursor-pointer hover:text-amber-400">★</label>
                                    <input type="radio" id="star4" name="rating" value="4" x-model="review.rating" class="hidden" /><label for="star4" class="text-xl text-slate-200 cursor-pointer hover:text-amber-400">★</label>
                                    <input type="radio" id="star3" name="rating" value="3" x-model="review.rating" class="hidden" /><label for="star3" class="text-xl text-slate-200 cursor-pointer hover:text-amber-400">★</label>
                                    <input type="radio" id="star2" name="rating" value="2" x-model="review.rating" class="hidden" /><label for="star2" class="text-xl text-slate-200 cursor-pointer hover:text-amber-400">★</label>
                                    <input type="radio" id="star1" name="rating" value="1" x-model="review.rating" class="hidden" /><label for="star1" class="text-xl text-slate-200 cursor-pointer hover:text-amber-400">★</label>
                                </div>
                            </div>
                            <textarea x-model="review.comment" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brand-500" rows="2" placeholder="Comentario..."></textarea>
                            <button type="submit" class="w-full text-white font-bold py-2.5 rounded-xl text-xs active:scale-95 transition" style="background-color: var(--color-primary);">Enviar Calificación</button>
                        </form>
                    </div>

                    <div class="space-y-4 max-h-[300px] overflow-y-auto scrollbar-none pr-1">
                        @forelse($reviews as $rev)
                        <div class="border-b border-slate-100 pb-3 last:border-none">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-slate-800">{{ $rev->customer_name }}</span>
                                <span class="text-xs text-amber-500">
                                    @for($i=1; $i<=5; $i++)
                                        @if($i <= $rev->rating) ★ @else ☆ @endif
                                    @endfor
                                </span>
                            </div>
                            @if($rev->comment)
                                <p class="text-xs text-slate-400 mt-1">"{{ $rev->comment }}"</p>
                            @endif
                        </div>
                        @empty
                        <p class="text-xs text-slate-400 text-center py-4">Sin comentarios registrados.</p>
                        @endforelse
                    </div>
                </section>
            </div>

            <!-- C. COLUMNA DERECHA: CARRITO FIJO EN ESCRITORIO (md:block) -->
            <!-- MD: 3 COLUMNAS DE ANCHO -->
            <div class="hidden lg:col-span-3 lg:block lg:sticky lg:top-6 space-y-6">
                <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-md flex flex-col justify-between max-h-[90vh]">
                    <div class="overflow-y-auto scrollbar-none">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-black text-slate-800">Tu Pedido</h2>
                            <span class="bg-slate-100 text-slate-600 text-xs font-bold px-2 py-0.5 rounded" x-text="totalItems"></span>
                        </div>

                        <!-- Lista de productos -->
                        <div class="space-y-3.5 mb-6" x-show="cart.length > 0">
                            <template x-for="item in cart" :key="item.id">
                                <div class="bg-slate-50 border border-slate-100/60 p-3 rounded-2xl">
                                    <div class="flex justify-between items-start">
                                        <span class="text-xs font-bold text-slate-800" x-text="item.name"></span>
                                        <span class="text-xs font-black text-slate-900" x-text="'$' + (item.price * item.quantity).toFixed(2)"></span>
                                    </div>
                                    <div class="flex justify-between items-center mt-2.5">
                                        <span class="text-[10px] text-slate-400" x-text="'Precio unitario: $' + parseFloat(item.price).toFixed(2)"></span>
                                        <div class="flex items-center gap-2">
                                            <button class="w-6 h-6 rounded-full bg-white border border-slate-200 flex items-center justify-center font-bold text-xs" @click="updateQty(item.id, -1)">-</button>
                                            <span class="text-xs font-extrabold text-slate-800" x-text="item.quantity"></span>
                                            <button class="w-6 h-6 rounded-full bg-white border border-slate-200 flex items-center justify-center font-bold text-xs" @click="updateQty(item.id, 1)">+</button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <div x-show="cart.length === 0" class="text-center py-8">
                            <p class="text-xs text-slate-400">Tu pedido está vacío.</p>
                        </div>

                        <!-- Datos de entrega -->
                        <div class="border-t border-slate-100 pt-5 space-y-3" x-show="cart.length > 0">
                            <h3 class="text-xs font-black text-slate-800">Datos de Entrega</h3>
                            <input type="text" x-model="customerName" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs placeholder-slate-400 focus:outline-none focus:border-brand-500" placeholder="Nombre completo">
                        </div>
                    </div>

                    <!-- Botón Checkout -->
                    <div class="border-t border-slate-100 pt-5 mt-6" x-show="cart.length > 0">
                        <div class="flex justify-between items-center text-sm font-black mb-4">
                            <span>Total del Pedido:</span>
                            <span class="text-lg text-[var(--color-primary)]" x-text="'$' + total.toFixed(2)"></span>
                        </div>
                        <button @click="sendWhatsApp()" class="w-full bg-[#25D366] hover:bg-[#20ba56] text-white font-extrabold py-3.5 rounded-2xl flex items-center justify-center gap-2 text-xs transition active:scale-95 shadow-md shadow-emerald-500/10">
                            Enviar por WhatsApp
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- MÓVIL: STICKY FLOATING CART BAR (md:hidden) -->
    <div class="md:hidden fixed bottom-4 left-4 right-4 z-50" x-show="totalItems > 0" x-transition style="display: none;">
        <button class="w-full rounded-2xl py-4 px-6 flex justify-between items-center text-white font-extrabold shadow-lg active:scale-95 transition"
                style="background-color: var(--color-primary);"
                @click="isCartOpen = true">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 w-8 h-8 rounded-lg flex items-center justify-center text-sm font-black">
                    <span x-text="totalItems"></span>
                </div>
                <span class="text-sm uppercase tracking-wide">Ver mi Pedido</span>
            </div>
            <div class="flex items-center gap-1.5 text-lg">
                <span x-text="'$' + total.toFixed(2)"></span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </div>
        </button>
    </div>

    <!-- MÓVIL: BOTTOM SHEET CHECKOUT MODAL (md:hidden) -->
    <div class="md:hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[998]" 
         x-show="isCartOpen" @click="isCartOpen = false" x-transition style="display: none;"></div>

    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white rounded-t-[2.5rem] shadow-2xl border-t border-slate-100 z-[999] max-h-[85vh] flex flex-col justify-between overflow-hidden"
         x-show="isCartOpen" x-transition:enter="ease-out duration-300 transform" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0" x-transition:leave="ease-in duration-200 transform" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full" style="display: none;">
        <div class="py-3 flex justify-center cursor-pointer" @click="isCartOpen = false">
            <span class="w-12 h-1.5 rounded-full bg-slate-200"></span>
        </div>
        <div class="px-6 pb-6 flex-grow overflow-y-auto scrollbar-none">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-black text-slate-800">Mi Pedido</h2>
                <button @click="isCartOpen = false" class="text-xs font-bold text-slate-400 uppercase tracking-wide">Cerrar</button>
            </div>
            <div class="space-y-4 mb-6">
                <template x-for="item in cart" :key="item.id">
                    <div class="flex justify-between items-center bg-slate-50 border border-slate-100 p-4 rounded-2xl">
                        <div>
                            <span class="text-sm font-bold text-slate-800" x-text="item.name"></span>
                            <span class="block text-xs font-extrabold text-emerald-600 mt-0.5" x-text="'$' + (item.price * item.quantity).toFixed(2)"></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center font-bold" @click="updateQty(item.id, -1)">-</button>
                            <span class="text-sm font-extrabold text-slate-800" x-text="item.quantity"></span>
                            <button class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center font-bold" @click="updateQty(item.id, 1)">+</button>
                        </div>
                    </div>
                </template>
            </div>
            <div class="border-t border-slate-100 pt-6 space-y-4">
                <h3 class="text-sm font-black text-slate-800">Datos de Entrega</h3>
                <input type="text" x-model="customerName" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:border-brand-500" placeholder="Nombre completo">
            </div>
        </div>
        <div class="p-6 bg-slate-50 border-t border-slate-100">
            <div class="flex justify-between items-center text-lg font-black text-slate-800 mb-4">
                <span>Total del Pedido:</span>
                <span x-text="'$' + total.toFixed(2)"></span>
            </div>
            <button @click="sendWhatsApp()" class="w-full bg-[#25D366] text-white font-extrabold py-4 rounded-2xl flex items-center justify-center gap-2 active:scale-95 transition shadow-lg shadow-emerald-500/10">
                Enviar por WhatsApp
            </button>
        </div>
    </div>

    <!-- Script de inicialización -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                const loader = document.getElementById('app-loader');
                if (loader) {
                    loader.style.opacity = '0';
                    setTimeout(() => loader.remove(), 500);
                }
            }, 1000);
        });

        function storeApp() {
            return {
                cart: JSON.parse(localStorage.getItem('cart') || '[]'),
                customerName: localStorage.getItem('customerName') || '',
                isCartOpen: false,
                activeCategory: {{ $categories->first()->id ?? 0 }},
                review: { name: '', rating: '5', comment: '' },
                isSubmitting: false,
                reviewSubmitted: false,

                init() {
                    this.$watch('cart', val => localStorage.setItem('cart', JSON.stringify(val)));
                    this.$watch('customerName', val => localStorage.setItem('customerName', val));
                },

                get total() { return this.cart.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0); },
                get totalItems() { return this.cart.reduce((sum, item) => sum + item.quantity, 0); },

                addToCart(product) {
                    let existing = this.cart.find(i => i.id === product.id);
                    if (existing) { existing.quantity++; } else { this.cart.push({ ...product, quantity: 1 }); }
                },

                updateQty(id, amount) {
                    let item = this.cart.find(i => i.id === id);
                    if (item) {
                        item.quantity += amount;
                        if (item.quantity <= 0) this.cart = this.cart.filter(i => i.id !== id);
                    }
                },

                scrollToReviews() {
                    document.getElementById('reviews-section').scrollIntoView({ behavior: 'smooth' });
                },

                async submitReview() {
                    if(!this.review.name || !this.review.rating) return;
                    this.isSubmitting = true;
                    try {
                        let response = await fetch('/{{ $company['slug'] }}/reviews', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                customer_name: this.review.name,
                                rating: parseInt(this.review.rating),
                                comment: this.review.comment
                            })
                        });
                        if(response.ok) {
                            this.reviewSubmitted = true;
                            setTimeout(() => window.location.reload(), 1500);
                        }
                    } catch (error) {
                        alert('Error al enviar calificación');
                    } finally {
                        this.isSubmitting = false;
                    }
                },

                sendWhatsApp() {
                    if(this.cart.length === 0) return alert('Carrito vacío');
                    if(!this.customerName.trim()) return alert('Ingresa tu nombre');
                    let text = `*Pedido de ${this.customerName}*%0A%0A`;
                    this.cart.forEach(i => {
                        text += `▫️ ${i.quantity}x ${i.name} - $${(i.price * i.quantity).toFixed(2)}%0A`;
                    });
                    text += `%0A*TOTAL:* $${this.total.toFixed(2)}`;
                    window.open(`https://wa.me/{{ $company['whatsapp'] }}?text=${text}`, '_blank');
                }
            }
        }
    </script>
</body>
</html>
