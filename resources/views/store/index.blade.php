<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $company['name'] }} - Menú Digital</title>
    
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
    
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Leaflet para el Mapa -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.02); }
        ::-webkit-scrollbar-thumb { background: var(--color-primary); border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--color-secondary); }
        * { scrollbar-width: thin; scrollbar-color: var(--color-primary) rgba(0, 0, 0, 0.02); }
    </style>
</head>
<body class="min-h-screen text-slate-800 pb-24 select-none" x-data="storeApp()">

@php
    $currencySymbol = '$';
    $bc = strtolower($company['base_currency'] ?? 'usd');
    if ($bc === 'eur') $currencySymbol = '€';
    elseif ($bc === 'bs' || $bc === 'ves') $currencySymbol = 'Bs.';
    elseif ($bc === 'cop') $currencySymbol = 'COP ';
@endphp

    <!-- LOADER -->
    <div id="app-loader" class="fixed inset-0 bg-white flex flex-col justify-center items-center z-[9999] transition-opacity duration-500">
        <div class="w-14 h-14 border-4 border-slate-100 rounded-full animate-spin" style="border-top-color: var(--color-primary);"></div>
        <span class="mt-4 text-xs font-semibold tracking-wider text-slate-400 uppercase">Cargando Menú...</span>
    </div>

    <!-- PORTADA / BANNER DE LA TIENDA (MÓVIL Y PC) -->
    <div class="relative h-48 md:h-64 w-full bg-slate-900 overflow-hidden shadow-inner">
        <img src="{{ $company['cover'] }}" alt="Portada" class="w-full h-full object-cover opacity-80">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 md:px-8 -mt-16 md:-mt-24 relative z-30 pt-4 md:pt-0">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <!-- A. COLUMNA IZQUIERDA (Info Tienda) -->
            <div class="md:col-span-4 lg:col-span-3 md:sticky md:top-6 space-y-6">
                <div class="relative bg-white/90 backdrop-blur-md border border-white/50 rounded-3xl p-6 shadow-xl text-center z-20 md:z-auto">
                    <div class="absolute -top-12 md:-top-10 left-1/2 -translate-x-1/2 w-24 h-24 rounded-full border-4 border-white bg-white shadow-lg overflow-hidden">
                        <img src="{{ $company['logo'] }}" alt="Logo" class="w-full h-full object-cover">
                    </div>

                    <div class="pt-12">
                        <h1 class="text-xl md:text-2xl font-black tracking-tight" style="color: var(--color-secondary);">
                            {{ $company['name'] }}
                        </h1>
                        <p class="text-xs text-slate-400 mt-1 flex items-center justify-center gap-1">
                            <i class="fas fa-map-marker-alt"></i>
                            @if(!empty($company['google_maps_link']))
                                <a href="{{ $company['google_maps_link'] }}" target="_blank" class="hover:underline hover:text-slate-600 transition">{{ $company['address'] }}</a>
                            @else
                                {{ $company['address'] }}
                            @endif
                        </p>

                        <div class="flex flex-wrap items-center justify-center gap-2 mt-4 text-[10px] md:text-xs font-semibold">
                            @php
                                $isOpen = true; // Lógica simplificada de horario
                            @endphp
                            @if($isOpen)
                            <span class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full border border-emerald-100 flex items-center gap-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span> Abierto
                            </span>
                            @endif
                            <span class="bg-amber-50 text-amber-600 px-3 py-1 rounded-full border border-amber-100 flex items-center gap-1">
                                ⭐ {{ number_format($averageRating, 1) }}
                            </span>
                        </div>

                        <p class="text-sm text-slate-500 mt-4 leading-relaxed">
                            {{ $company['description'] ?: '¡Haz tu pedido en línea de forma rápida y sencilla!' }}
                        </p>

                        <div class="hidden md:block mt-6 text-left border-t border-slate-100 pt-4">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Métodos de Pago</h4>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach(explode(',', $company['payment_methods'] ?: 'Pago Móvil,Efectivo') as $method)
                                    <span class="bg-slate-50 text-slate-600 border border-slate-200 text-[10px] font-bold px-2.5 py-1 rounded">{{ trim($method) }}</span>
                                @endforeach
                            </div>
                        </div>

                        @if(!empty($company['exchange_rate']))
                        <div class="mt-5 w-full bg-[#fff8e6] border border-[#ffe199] rounded-2xl px-4 py-2.5 flex flex-col items-center shadow-sm">
                            <span class="text-amber-800 text-[10px] font-extrabold uppercase tracking-wide">Tasa Monetaria</span>
                            <span class="text-base font-black text-amber-950 mt-0.5">{{ $company['exchange_rate'] }}</span>
                            @if(!empty($company['exchange_updated_at']))
                            <span class="text-[9px] text-amber-700/80 font-semibold">Act: {{ $company['exchange_updated_at'] }}</span>
                            @endif
                        </div>
                        @endif

                        <!-- BOTÓN OPINIONES -->
                        <button @click="showReviewsModal = true" class="mt-4 w-full bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 transition active:scale-95">
                            <i class="fas fa-comment-dots"></i> 
                            <span>Ver Opiniones</span>
                            <span class="bg-slate-200/80 text-slate-600 text-[10px] px-2 py-0.5 rounded-full font-extrabold ml-1 shadow-sm">{{ $reviews->count() }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- B. COLUMNA CENTRAL (Buscador, Categorías y Productos) -->
            <div class="md:col-span-8 lg:col-span-9 space-y-6">
                
                <!-- Buscador Dinámico -->
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-2 shadow-sm border border-slate-100 flex items-center gap-2">
                    <i class="fas fa-search text-slate-400 ml-3"></i>
                    <input type="text" x-model="searchQuery" placeholder="Buscar productos..." class="w-full bg-transparent border-none focus:ring-0 text-sm py-2 px-2 text-slate-800 placeholder-slate-400">
                    <button x-show="searchQuery !== ''" @click="searchQuery = ''" class="mr-3 text-slate-400 hover:text-rose-500"><i class="fas fa-times"></i></button>
                </div>

                <!-- Categorías (Navegación Horizontal) -->
                <div class="sticky top-0 bg-white/90 backdrop-blur-md border border-slate-100 py-3 z-40 shadow-sm rounded-2xl px-4 overflow-x-auto flex items-center gap-2 whitespace-nowrap scrollbar-none">
                    <a href="#" class="px-4 py-2 rounded-full text-xs font-bold transition duration-200 border"
                       :class="activeCategory === 0 ? 'bg-[var(--color-primary)] border-[var(--color-primary)] text-white shadow-sm' : 'bg-white border-slate-200 text-slate-500 hover:bg-slate-50'"
                       @click.prevent="activeCategory = 0">
                        Todas
                    </a>
                    @foreach($categories as $category)
                        @if($category->products->count() > 0)
                        <a href="#cat-{{ $category->id }}" 
                           class="px-4 py-2 rounded-full text-xs font-bold transition duration-200 border"
                           :class="activeCategory === {{ $category->id }} ? 'bg-[var(--color-primary)] border-[var(--color-primary)] text-white shadow-sm' : 'bg-white border-slate-200 text-slate-500 hover:bg-slate-50'"
                           @click.prevent="activeCategory = {{ $category->id }}">
                            {{ $category->name }}
                        </a>
                        @endif
                    @endforeach
                </div>

                <!-- PRODUCTOS -->
                <div>
                    @foreach($categories as $category)
                        @if($category->products->count() > 0)
                        <section id="cat-{{ $category->id }}" class="mb-10" x-show="activeCategory === 0 || activeCategory === {{ $category->id }}">
                            <div class="flex items-center gap-2.5 mb-4">
                                <span class="w-1.5 h-6 rounded-full" style="background-color: var(--color-primary);"></span>
                                <h2 class="text-lg font-black tracking-tight" style="color: var(--color-secondary);">{{ $category->name }}</h2>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($category->products as $product)
                                <div class="bg-white border border-slate-100 rounded-3xl p-3 shadow-sm flex flex-col justify-between relative overflow-hidden group"
                                     x-show="searchQuery === '' || '{{ strtolower(str_replace("'", "\'", $product->name)) }}'.includes(searchQuery.toLowerCase())">
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
                                            <span class="text-sm md:text-base font-extrabold text-slate-900">{{ $currencySymbol }}{{ number_format($product->price, 2) }}</span>
                                            <button class="w-8 h-8 rounded-full text-white flex items-center justify-center shadow active:scale-90 transition"
                                                    style="background-color: var(--color-primary);"
                                                    @click="addToCart({{ $product->toJson() }})">
                                                <i class="fas fa-plus text-xs"></i>
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
            </div>
        </div>
    </div>

    <!-- FLOATING CART BUTTON -->
    <div class="fixed bottom-6 right-6 z-40" x-show="totalItems > 0" x-transition style="display: none;">
        <button @click="isCartOpen = true" class="relative w-16 h-16 rounded-full flex items-center justify-center text-white shadow-[0_8px_30px_rgba(0,0,0,0.3)] hover:scale-105 active:scale-95 transition-transform" style="background-color: var(--color-primary);">
            <i class="fas fa-shopping-bag text-2xl"></i>
            <span class="absolute -top-1 -right-1 bg-rose-500 text-white text-[11px] font-black w-6 h-6 rounded-full flex items-center justify-center border-2 border-white shadow-sm" x-text="totalItems"></span>
        </button>
    </div>

    <!-- CART MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="isCartOpen" @click="isCartOpen = false" x-transition style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden"
         x-show="isCartOpen" x-transition style="display: none;">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white">
            <h2 class="text-xl font-black text-slate-800">Mi Pedido</h2>
            <button @click="isCartOpen = false" class="text-slate-400 hover:text-rose-500 w-8 h-8 flex items-center justify-center rounded-full bg-slate-50"><i class="fas fa-times"></i></button>
        </div>
        <div class="p-6 flex-grow overflow-y-auto scrollbar-none bg-slate-50">
            <div class="space-y-3 mb-6">
                <template x-for="item in cart" :key="item.id">
                    <div class="flex justify-between items-center bg-white border border-slate-100 p-4 rounded-2xl shadow-sm">
                        <div>
                            <span class="text-sm font-bold text-slate-800 block" x-text="item.name"></span>
                            <span class="text-xs font-extrabold text-[var(--color-primary)]" x-text="currencySymbol + (item.price * item.quantity).toFixed(2)"></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="w-7 h-7 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center font-bold text-xs" @click="updateQty(item.id, -1)">-</button>
                            <span class="text-sm font-extrabold text-slate-800" x-text="item.quantity"></span>
                            <button class="w-7 h-7 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center font-bold text-xs" @click="updateQty(item.id, 1)">+</button>
                        </div>
                    </div>
                </template>
                <div x-show="cart.length === 0" class="text-center py-8 text-sm text-slate-400">El carrito está vacío.</div>
            </div>
            
            <div class="border-t border-slate-200 pt-6" x-show="cart.length > 0">
                <h3 class="text-sm font-black text-slate-800 mb-3">Datos de Entrega</h3>
                
                <div class="flex bg-slate-100 rounded-xl p-1 mb-4">
                    <button @click="deliveryType = 'pickup'; deliveryCost = 0" :class="deliveryType === 'pickup' ? 'bg-white shadow-sm text-slate-800 font-bold' : 'text-slate-500 font-medium'" class="flex-1 py-2 text-xs rounded-lg transition">Retiro en local</button>
                    <button @click="deliveryType = 'delivery'; if(!mapInitialized) initMap()" :class="deliveryType === 'delivery' ? 'bg-white shadow-sm text-slate-800 font-bold' : 'text-slate-500 font-medium'" class="flex-1 py-2 text-xs rounded-lg transition">Delivery</button>
                </div>

                <div x-show="deliveryType === 'delivery'" class="mb-4 space-y-2">
                    <p class="text-[10px] text-slate-500 font-bold">Mueve el marcador a tu ubicación de entrega:</p>
                    <div id="delivery-map" class="w-full h-40 rounded-xl border border-slate-200 z-10" wire:ignore></div>
                    <p x-show="deliveryCost > 0" class="text-xs text-emerald-700 font-bold bg-emerald-50 p-2.5 rounded-xl text-center border border-emerald-100 mt-2">
                        Distancia: <span x-text="deliveryDistance.toFixed(1)"></span> km <br>
                        Costo de Envío: <span x-text="currencySymbol + deliveryCost.toFixed(2)"></span>
                    </p>
                </div>

                <div class="space-y-3">
                    <input type="text" x-model="customerName" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:border-[var(--color-primary)] shadow-sm" placeholder="Tu nombre completo">
                    <input type="tel" x-model="customerPhone" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:border-[var(--color-primary)] shadow-sm" placeholder="Tu número de celular / WhatsApp">
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border-t border-slate-100">
            <div class="flex justify-between items-center text-lg font-black text-slate-800 mb-4">
                <span>Total:</span>
                <span x-text="currencySymbol + (total + deliveryCost).toFixed(2)"></span>
            </div>
            <button @click="sendWhatsApp()" class="w-full bg-[#25D366] text-white font-extrabold py-3.5 rounded-2xl flex items-center justify-center gap-2 active:scale-95 transition shadow-lg shadow-emerald-500/20 text-sm">
                <i class="fab fa-whatsapp text-lg"></i> Confirmar y Enviar Pedido
            </button>
        </div>
    </div>

    <!-- REVIEWS MODAL -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[1000]" x-show="showReviewsModal" @click="showReviewsModal = false; showForm = false" x-transition style="display: none;"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl z-[1001] max-h-[90vh] flex flex-col overflow-hidden"
         x-show="showReviewsModal" x-transition style="display: none;" x-data="{ showForm: false }">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white">
            <h2 class="text-xl font-black text-slate-800">Opiniones</h2>
            <button @click="showReviewsModal = false" class="text-slate-400 hover:text-rose-500 w-8 h-8 flex items-center justify-center rounded-full bg-slate-50"><i class="fas fa-times"></i></button>
        </div>
        
        @php
            $totalReviews = $reviews->count();
            $count5 = $reviews->where('rating', 5)->count();
            $count4 = $reviews->where('rating', 4)->count();
            $count3 = $reviews->where('rating', 3)->count();
            $count2 = $reviews->where('rating', 2)->count();
            $count1 = $reviews->where('rating', 1)->count();

            $pct5 = $totalReviews > 0 ? ($count5 / $totalReviews) * 100 : 0;
            $pct4 = $totalReviews > 0 ? ($count4 / $totalReviews) * 100 : 0;
            $pct3 = $totalReviews > 0 ? ($count3 / $totalReviews) * 100 : 0;
            $pct2 = $totalReviews > 0 ? ($count2 / $totalReviews) * 100 : 0;
            $pct1 = $totalReviews > 0 ? ($count1 / $totalReviews) * 100 : 0;
        @endphp

        <!-- Resumen de Valoración y Distribución Visual (Histograma) -->
        <div class="px-6 py-5 bg-slate-50 border-b border-slate-100 grid grid-cols-12 gap-4 items-center select-none">
            <!-- Puntuación Promedio (Hacer click aquí resetea a 'Todas') -->
            <div @click="starFilter = 0" 
                 class="col-span-4 text-center border-r border-slate-200/80 pr-3 flex flex-col justify-center items-center cursor-pointer p-2.5 rounded-2xl transition hover:bg-slate-200/40"
                 :class="starFilter === 0 ? 'bg-slate-250 ring-1 ring-slate-200/60' : ''"
                 title="Ver todas las opiniones">
                <span class="text-4xl font-black text-slate-800 leading-none">{{ number_format($averageRating, 1) }}</span>
                <div class="flex justify-center text-amber-400 text-xs my-1.5 gap-0.5">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($averageRating))
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block">
                    {{ $totalReviews }} {{ $totalReviews == 1 ? 'opinión' : 'opiniones' }}
                </span>
            </div>

            <!-- Distribución / Histograma de Barras (Filtrables al hacer click) -->
            <div class="col-span-8 space-y-1 pl-3">
                @foreach([5, 4, 3, 2, 1] as $star)
                    @php
                        $cStar = ${"count".$star};
                        $pctStar = ${"pct".$star};
                    @endphp
                    <div @click="starFilter = starFilter === {{ $star }} ? 0 : {{ $star }}"
                         class="flex items-center gap-2 text-[10px] font-bold text-slate-500 cursor-pointer p-1 rounded-xl transition hover:bg-slate-200/50"
                         :class="starFilter === {{ $star }} ? 'bg-amber-100/50 text-amber-900 ring-1 ring-amber-200/70' : ''"
                         title="Filtrar por {{ $star }} estrellas">
                        <span class="w-3 text-right">{{ $star }}</span>
                        <i class="fas fa-star text-amber-400 text-[8px]"></i>
                        <div class="flex-grow bg-slate-200 rounded-full h-2 overflow-hidden shadow-inner">
                            <div class="bg-amber-400 h-full rounded-full transition-all duration-500" style="width: {{ $pctStar }}%"></div>
                        </div>
                        <span class="w-6 text-right text-slate-400 font-semibold">{{ $cStar }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Banner de Filtro Activo -->
        <div x-show="starFilter !== 0" x-cloak x-transition
             class="px-6 py-2.5 bg-amber-50/50 border-b border-slate-100 flex justify-between items-center text-xs select-none">
            <span class="text-amber-800/90 font-bold flex items-center gap-1.5">
                <span class="inline-block w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                Mostrando opiniones de <span x-text="starFilter" class="underline decoration-amber-400 font-black"></span> estrellas
            </span>
            <button @click="starFilter = 0" class="text-[var(--color-primary)] hover:underline font-extrabold text-[10px] uppercase tracking-wider transition active:scale-95">
                Ver Todas
            </button>
        </div>

        <div class="p-6 flex-grow overflow-y-auto scrollbar-none bg-slate-50">
            <div class="space-y-4">
                @forelse($reviews as $rev)
                    <div x-show="starFilter === 0 || starFilter === {{ $rev->rating }}" class="bg-white border border-slate-100 p-4 rounded-2xl shadow-sm">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-bold text-slate-800">{{ $rev->customer_name }}</span>
                            <span class="text-xs text-amber-500">
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= $rev->rating) <i class="fas fa-star"></i> @else <i class="far fa-star"></i> @endif
                                @endfor
                            </span>
                        </div>
                        @if($rev->comment)
                            <p class="text-xs text-slate-500 mt-2 italic">"{{ $rev->comment }}"</p>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-slate-400 text-center py-4">No hay opiniones disponibles.</p>
                @endforelse
            </div>
        </div>

        <div class="p-6 bg-white border-t border-slate-100 flex flex-col gap-3 select-none">
            <!-- Botón para desplegar el formulario -->
            <button x-show="!showForm" @click="showForm = true"
                    class="w-full bg-[var(--color-primary)] hover:brightness-110 text-white font-extrabold py-3 rounded-2xl text-xs transition shadow-lg shadow-[var(--color-primary)]/15 flex items-center justify-center gap-2 active:scale-[0.98]">
                <i class="fas fa-pen-fancy"></i> Agregar Opinión
            </button>

            <!-- Bloque del Formulario Desplegado -->
            <div x-show="showForm" x-cloak x-transition:enter="transition ease-out duration-250" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-3">
                <div class="flex justify-between items-center mb-1">
                    <h3 class="text-sm font-black text-slate-800">Deja tu opinión</h3>
                    <button @click="showForm = false" class="text-slate-400 hover:text-slate-600 text-xs font-bold transition">Cancelar</button>
                </div>
                
                <div x-show="reviewSubmitted" class="bg-emerald-50 text-emerald-700 text-sm font-bold p-3 rounded-xl border border-emerald-100 text-center mb-0">¡Gracias por tu valoración!</div>
                <form @submit.prevent="submitReview" x-show="!reviewSubmitted" class="flex flex-col gap-3">
                    <div class="flex items-center gap-2 mb-1">
                        <input type="checkbox" id="anon" x-model="review.anonymous" class="rounded border-slate-300 text-[var(--color-primary)]">
                        <label for="anon" class="text-xs font-bold text-slate-600 cursor-pointer">Comentar como Anónimo</label>
                    </div>
                    <input type="text" x-show="!review.anonymous" x-model="review.name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none" placeholder="Tu nombre">
                    
                    <div class="flex items-center justify-between bg-slate-50 border border-slate-200 rounded-xl px-4 py-2" x-data="{ hoverRating: 0 }">
                        <span class="text-xs font-bold text-slate-500">Valoración:</span>
                        <div class="flex gap-1 flex-row-reverse" @mouseleave="hoverRating = 0">
                            <!-- Estrella 5 -->
                            <input type="radio" id="star5" name="rating" value="5" x-model="review.rating" class="hidden" required/>
                            <label for="star5" class="text-lg cursor-pointer transition duration-150"
                                   @mouseenter="hoverRating = 5"
                                   :class="(hoverRating ? hoverRating >= 5 : parseInt(review.rating) >= 5) ? 'text-amber-400 scale-110' : 'text-slate-300'">
                                <i class="fas fa-star"></i>
                            </label>

                            <!-- Estrella 4 -->
                            <input type="radio" id="star4" name="rating" value="4" x-model="review.rating" class="hidden"/>
                            <label for="star4" class="text-lg cursor-pointer transition duration-150"
                                   @mouseenter="hoverRating = 4"
                                   :class="(hoverRating ? hoverRating >= 4 : parseInt(review.rating) >= 4) ? 'text-amber-400 scale-110' : 'text-slate-300'">
                                <i class="fas fa-star"></i>
                            </label>

                            <!-- Estrella 3 -->
                            <input type="radio" id="star3" name="rating" value="3" x-model="review.rating" class="hidden"/>
                            <label for="star3" class="text-lg cursor-pointer transition duration-150"
                                   @mouseenter="hoverRating = 3"
                                   :class="(hoverRating ? hoverRating >= 3 : parseInt(review.rating) >= 3) ? 'text-amber-400 scale-110' : 'text-slate-300'">
                                <i class="fas fa-star"></i>
                            </label>

                            <!-- Estrella 2 -->
                            <input type="radio" id="star2" name="rating" value="2" x-model="review.rating" class="hidden"/>
                            <label for="star2" class="text-lg cursor-pointer transition duration-150"
                                   @mouseenter="hoverRating = 2"
                                   :class="(hoverRating ? hoverRating >= 2 : parseInt(review.rating) >= 2) ? 'text-amber-400 scale-110' : 'text-slate-300'">
                                <i class="fas fa-star"></i>
                            </label>

                            <!-- Estrella 1 -->
                            <input type="radio" id="star1" name="rating" value="1" x-model="review.rating" class="hidden"/>
                            <label for="star1" class="text-lg cursor-pointer transition duration-150"
                                   @mouseenter="hoverRating = 1"
                                   :class="(hoverRating ? hoverRating >= 1 : parseInt(review.rating) >= 1) ? 'text-amber-400 scale-110' : 'text-slate-300'">
                                <i class="fas fa-star"></i>
                            </label>
                        </div>
                    </div>
                    <textarea x-model="review.comment" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none" rows="2" placeholder="Opcional: Escribe un comentario..."></textarea>
                    <button type="submit" class="w-full text-white font-bold py-3 rounded-xl text-xs active:scale-95 transition mt-1" style="background-color: var(--color-primary);">Enviar Calificación</button>
                </form>
            </div>
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
                customerPhone: localStorage.getItem('customerPhone') || '',
                isCartOpen: false,
                showReviewsModal: false,
                activeCategory: 0,
                searchQuery: '',
                starFilter: 0,
                review: { name: '', rating: '5', comment: '', anonymous: false },
                isSubmitting: false,
                reviewSubmitted: false,
                currencySymbol: '{{ $currencySymbol }}',
                
                deliveryType: 'pickup',
                deliveryDistance: 0,
                deliveryCost: 0,
                mapInitialized: false,
                map: null,
                marker: null,
                storeLat: parseFloat('{{ $company['latitude'] ?? 0 }}'),
                storeLng: parseFloat('{{ $company['longitude'] ?? 0 }}'),
                deliveryRate: parseFloat('{{ $company['delivery_rate_per_km'] ?? 0 }}'),

                init() {
                    this.$watch('cart', val => localStorage.setItem('cart', JSON.stringify(val)));
                    this.$watch('customerName', val => localStorage.setItem('customerName', val));
                    this.$watch('customerPhone', val => localStorage.setItem('customerPhone', val));
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

                async submitReview() {
                    let finalName = this.review.anonymous ? 'Anónimo' : this.review.name.trim();
                    if(!finalName) return alert('Por favor ingresa tu nombre o marca la casilla de anónimo.');
                    if(!this.review.rating) return alert('Por favor selecciona una valoración en estrellas.');

                    this.isSubmitting = true;
                    try {
                        let response = await fetch('/{{ $company['slug'] }}/reviews', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                customer_name: finalName,
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

                initMap() {
                    if (this.mapInitialized || !this.storeLat || !this.storeLng) return;
                    setTimeout(() => {
                        let center = [this.storeLat, this.storeLng];
                        this.map = L.map('delivery-map').setView(center, 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(this.map);
                        
                        this.marker = L.marker(center, {draggable: true}).addTo(this.map);
                        
                        this.marker.on('dragend', (e) => {
                            let pos = e.target.getLatLng();
                            this.calculateDistance(pos.lat, pos.lng);
                        });
                        
                        this.map.on('click', (e) => {
                            this.marker.setLatLng(e.latlng);
                            this.calculateDistance(e.latlng.lat, e.latlng.lng);
                        });
                        
                        this.mapInitialized = true;
                    }, 300);
                },

                calculateDistance(lat2, lon2) {
                    if (!this.storeLat || !this.storeLng) return;
                    let lat1 = this.storeLat;
                    let lon1 = this.storeLng;
                    
                    const R = 6371;
                    const dLat = (lat2 - lat1) * Math.PI / 180;
                    const dLon = (lon2 - lon1) * Math.PI / 180;
                    const a = 
                        Math.sin(dLat/2) * Math.sin(dLat/2) +
                        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
                        Math.sin(dLon/2) * Math.sin(dLon/2);
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
                    const d = R * c; 
                    
                    this.deliveryDistance = d;
                    this.deliveryCost = d * this.deliveryRate;
                },

                async sendWhatsApp() {
                    if(this.cart.length === 0) return alert('Carrito vacío');
                    if(!this.customerName.trim()) return alert('Por favor ingresa tu nombre para el pedido.');
                    if(!this.customerPhone.trim()) return alert('Por favor ingresa tu número de teléfono (celular).');
                    if(this.deliveryType === 'delivery' && (!this.storeLat || !this.storeLng)) return alert('El servicio de delivery no está disponible. Coordenadas de tienda no configuradas.');

                    try {
                        await fetch('/{{ $company['slug'] }}/clients/quick-register', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                name: this.customerName,
                                phone: this.customerPhone
                            })
                        });
                    } catch (e) { console.error('Error', e); }

                    let text = `*Pedido de ${this.customerName}*%0A`;
                    text += `*Teléfono:* ${this.customerPhone}%0A`;
                    text += `*Tipo:* ${this.deliveryType === 'delivery' ? 'Delivery' : 'Retiro en local'}%0A%0A`;
                    
                    this.cart.forEach(i => {
                        text += `▫️ ${i.quantity}x ${i.name} - ${this.currencySymbol}${(i.price * i.quantity).toFixed(2)}%0A`;
                    });

                    if (this.deliveryType === 'delivery' && this.marker) {
                        text += `%0A*Costo de Envío:* ${this.currencySymbol}${this.deliveryCost.toFixed(2)}`;
                        text += `%0A*Ubicación:* https://www.google.com/maps?q=${this.marker.getLatLng().lat},${this.marker.getLatLng().lng}`;
                    }

                    text += `%0A%0A*TOTAL:* ${this.currencySymbol}${(this.total + this.deliveryCost).toFixed(2)}`;
                    window.open(`https://wa.me/{{ $company['whatsapp'] }}?text=${text}`, '_blank');
                }
            }
        }
    </script>
</body>
</html>
