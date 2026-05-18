<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Marca Blanca - {{ $shop->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '{{ $shop->color_primary }}',
                        secondary: '{{ $shop->color_secondary }}',
                        brand: {
                            50: '#f5f3ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        :root {
            --primary: {{ $shop->color_primary }};
            --secondary: {{ $shop->color_secondary }};
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.05);
            --radius: 0.75rem;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-color);
            color: var(--text-main);
            padding: 2rem 1rem;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-main);
        }

        .header-subtitle {
            color: var(--text-muted);
            margin-bottom: 2rem;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            padding: 2.5rem;
            margin-bottom: 2rem;
        }

        .alert-success {
            background: #dcfce7;
            color: #14532d;
            padding: 1rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .full-width {
            grid-column: span 2;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .input-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--text-main);
            transition: all 0.3s;
        }

        .input-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 0, 103, 0.15);
        }

        .color-pickers {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .color-box {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: #f1f5f9;
            padding: 0.8rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border-color);
        }

        .color-box input[type="color"] {
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            background: none;
        }

        .file-upload-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .file-box {
            border: 2px dashed var(--border-color);
            padding: 1.5rem;
            border-radius: var(--radius);
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .file-box:hover {
            border-color: var(--primary);
            background: rgba(230, 0, 103, 0.02);
        }

        .preview-img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-top: 1rem;
            border: 3px solid white;
            box-shadow: var(--shadow-md);
        }

        .preview-banner {
            max-width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 0.5rem;
            margin-top: 1rem;
        }

        .btn-submit {
            background: var(--primary);
            color: white;
            border: none;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 0.5rem;
            cursor: pointer;
            width: 100%;
            margin-top: 2rem;
            transition: 0.3s;
            text-align: center;
            box-shadow: 0 4px 12px rgba(230, 0, 103, 0.2);
        }

        .btn-submit:hover {
            filter: brightness(1.1);
            transform: translateY(-2px);
        }

        .view-store-link {
            display: inline-block;
            margin-top: 1rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;">
        <div>
            <h1 class="header-title">Configuración Visual</h1>
            <p class="header-subtitle" style="margin-bottom: 0;">Marca Blanca y Personalización de Tienda (SaaS)</p>
        </div>
        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <a href="/{{ $shop->slug }}/admin/dashboard" style="color: var(--text-muted); text-decoration: none; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 4px; border: 1px solid var(--border-color); padding: 0.5rem 1rem; border-radius: 0.5rem; transition: background 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">
                ← Panel
            </a>
            <a href="/" style="background: #fff1f2; color: #e11d48; text-decoration: none; font-weight: 700; font-size: 0.85rem; padding: 0.5rem 1rem; border-radius: 0.5rem; border: 1px solid #ffe4e6; transition: background 0.2s;" onmouseover="this.style.background='#ffe4e6'" onmouseout="this.style.background='#fff1f2'">
                Salir de la Demo
            </a>
            <a href="/{{ $shop->slug }}" class="view-store-link" target="_blank" style="margin-top: 0;">Ver mi tienda →</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="/{{ $shop->slug }}/admin/settings" method="POST" enctype="multipart/form-data" class="card">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <!-- Nombre de la Empresa -->
            <div class="form-group">
                <label for="name">Nombre de la Empresa</label>
                <input type="text" id="name" name="name" class="input-control" value="{{ old('name', $shop->name) }}" required>
            </div>

            <!-- WhatsApp de Pedidos -->
            <div class="form-group">
                <label for="whatsapp_number">WhatsApp (Formato Internacional)</label>
                <input type="text" id="whatsapp_number" name="whatsapp_number" class="input-control" value="{{ old('whatsapp_number', $shop->whatsapp_number) }}" required placeholder="e.g. 584120000000">
            </div>

            <!-- Descripción/Eslogan -->
            <div class="form-group full-width">
                <label for="description">Descripción o Eslogan</label>
                <textarea id="description" name="description" class="input-control" rows="2">{{ old('description', $shop->description) }}</textarea>
            </div>

            <!-- Ubicación -->
            <div class="form-group full-width">
                <label for="address">Dirección Física</label>
                <input type="text" id="address" name="address" class="input-control" value="{{ old('address', $shop->address) }}">
            </div>

            <!-- Métodos de Pago -->
            <div class="form-group full-width">
                <label for="payment_methods">Métodos de Pago (Separados por coma)</label>
                <input type="text" id="payment_methods" name="payment_methods" class="input-control" value="{{ old('payment_methods', $shop->payment_methods) }}" placeholder="e.g. Pago Móvil, Zelle, Efectivo">
            </div>
        </div>

        <!-- Paleta de Colores Dinámicos -->
        <h3 style="margin-top: 2rem; border-bottom: 2px solid var(--border-color); padding-bottom: 0.5rem;">Paleta de Colores de Marca</h3>
        <div class="color-pickers">
            <!-- Color Primario -->
            <div class="color-box">
                <input type="color" id="color_primary" name="color_primary" value="{{ old('color_primary', $shop->color_primary) }}">
                <div>
                    <label style="display: block;">Color Principal</label>
                    <span style="font-size: 0.8rem; color: var(--text-muted);">Botones y acciones</span>
                </div>
            </div>

            <!-- Color Secundario -->
            <div class="color-box">
                <input type="color" id="color_secondary" name="color_secondary" value="{{ old('color_secondary', $shop->color_secondary) }}">
                <div>
                    <label style="display: block;">Color Secundario</label>
                    <span style="font-size: 0.8rem; color: var(--text-muted);">Títulos y Badges</span>
                </div>
            </div>

            <!-- Color de Fondo -->
            <div class="color-box">
                <input type="color" id="color_background" name="color_background" value="{{ old('color_background', $shop->color_background) }}">
                <div>
                    <label style="display: block;">Fondo Menú</label>
                    <span style="font-size: 0.8rem; color: var(--text-muted);">Fondo general</span>
                </div>
            </div>
        </div>

        <!-- Activos Visuales (Imágenes) -->
        <h3 style="margin-top: 2rem; border-bottom: 2px solid var(--border-color); padding-bottom: 0.5rem;">Activos de Marca (Imágenes)</h3>
        <div class="file-upload-section">
            <!-- Cargar Logo -->
            <div class="file-box">
                <label style="display: block; margin-bottom: 0.5rem;">Logo Comercial</label>
                <input type="file" name="logo" accept="image/*" style="display: none;" id="logo-input">
                <button type="button" class="input-control" onclick="document.getElementById('logo-input').click()">Seleccionar Logo</button>
                @if($shop->logo_path)
                    <img src="{{ filter_var($shop->logo_path, FILTER_VALIDATE_URL) ? $shop->logo_path : asset('storage/'.$shop->logo_path) }}" alt="Preview" class="preview-img">
                @endif
            </div>

            <!-- Cargar Portada -->
            <div class="file-box">
                <label style="display: block; margin-bottom: 0.5rem;">Portada/Banner</label>
                <input type="file" name="cover" accept="image/*" style="display: none;" id="cover-input">
                <button type="button" class="input-control" onclick="document.getElementById('cover-input').click()">Seleccionar Portada</button>
                @if($shop->cover_path)
                    <img src="{{ filter_var($shop->cover_path, FILTER_VALIDATE_URL) ? $shop->cover_path : asset('storage/'.$shop->cover_path) }}" alt="Preview" class="preview-banner">
                @endif
            </div>
        </div>

        <button type="submit" class="btn-submit">Guardar Cambios Visuales</button>
    </form>

    <!-- COMPONENTE: GESTIÓN DE ENLACE CORTO (ACORTADOR INTERNO) -->
    <div class="bg-white border border-slate-200 rounded-[2rem] p-6 md:p-8 shadow-md mt-8 relative" x-data="{ showToast: false }">
        <div class="absolute -right-12 -top-12 w-28 h-28 bg-brand-500/5 rounded-full blur-xl"></div>

        <!-- Encabezado del Módulo -->
        <div class="mb-6">
            <span class="bg-brand-500/10 text-brand-600 text-[10px] uppercase font-extrabold tracking-wider px-3 py-1 rounded-full border border-brand-500/20">
                Marketing y Redes
            </span>
            <h3 class="text-lg md:text-xl font-bold text-slate-800 mt-3 mb-1">
                Enlace Corto Personalizado
            </h3>
            <p class="text-xs md:text-sm text-slate-500">
                Configura una palabra clave corta y fácil de recordar para compartir tu menú digital en Instagram, TikTok o tarjetas de presentación.
            </p>
        </div>

        @if(session('success_short_link'))
            <div class="bg-emerald-50 text-emerald-700 text-xs font-semibold p-4 rounded-xl border border-emerald-100 mb-6">
                {{ session('success_short_link') }}
            </div>
        @endif

        <!-- A. COMPONENTE "COPIAR LINK" (Si ya está configurado) -->
        @if($shortLink = $shop->shortLinks()->first())
            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 md:p-6 mb-6">
                <span class="text-[10px] uppercase font-extrabold text-slate-400 tracking-wider block mb-2">Enlace Corto Activo</span>
                
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <div class="flex-grow bg-white border border-slate-200 rounded-xl px-4 py-3 flex items-center justify-between text-xs md:text-sm text-slate-800 font-bold select-all overflow-x-auto shadow-sm">
                        <span>{{ str_replace(['http://', 'https://'], '', url('/l/' . $shortLink->code)) }}</span>
                        <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded font-normal shrink-0 ml-2">Activo</span>
                    </div>
                    
                    <button type="button" 
                            @click="navigator.clipboard.writeText('{{ url('/l/' . $shortLink->code) }}'); showToast = true; setTimeout(() => { showToast = false }, 2500);"
                            class="bg-brand-600 hover:bg-brand-700 text-white font-extrabold px-6 py-3 rounded-xl flex items-center justify-center gap-2 active:scale-95 transition text-xs shrink-0 shadow-md shadow-brand-500/10">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        Copiar Enlace
                    </button>
                </div>

                <!-- Métricas del Enlace -->
                <div class="mt-4 flex items-center gap-2 text-xs text-slate-500">
                    <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded bg-slate-100 text-slate-600 font-bold border border-slate-200/60">
                        📊 {{ $shortLink->clicks_count }} {{ $shortLink->clicks_count == 1 ? 'visita' : 'visitas' }}
                    </span>
                    <span>Registrado desde el acortador interno.</span>
                </div>
            </div>
        @endif

        <!-- B. FORMULARIO DE ASIGNACIÓN (Siempre editable) -->
        <form action="/{{ $shop->slug }}/admin/settings/short-link" method="POST" class="space-y-4">
            @csrf
            <div class="form-group">
                <label for="code" class="text-xs font-bold text-slate-700">Palabra clave o prefijo corto</label>
                
                <div class="flex items-stretch rounded-xl border border-slate-200 overflow-hidden focus-within:border-brand-500 focus-within:ring-2 focus-within:ring-brand-500/15 transition shadow-sm bg-white">
                    <span class="bg-slate-100 border-r border-slate-200 text-slate-500 px-4 py-3 flex items-center text-xs md:text-sm font-semibold select-none shrink-0">
                        wistore.com/l/
                    </span>
                    <input type="text" 
                           id="code" 
                           name="code" 
                           value="{{ old('code', $shop->shortLinks()->first()?->code) }}" 
                           placeholder="ej: {{ $shop->slug }}" 
                           required 
                           class="w-full px-4 py-3 text-xs md:text-sm text-slate-800 font-bold placeholder-slate-400 focus:outline-none bg-transparent">
                </div>

                @error('code')
                    <span class="text-red-500 text-xs mt-1 block font-semibold">{{ $message }}</span>
                @enderror
                <p class="text-[10px] text-slate-400 mt-1.5 leading-relaxed">
                    Usa palabras simples, sin espacios ni caracteres especiales. Ej: 'ys', 'detallitos', 'regalos'.
                </p>
            </div>

            <button type="submit" 
                    class="bg-slate-900 hover:bg-slate-800 text-white font-extrabold py-3.5 px-6 rounded-xl transition text-xs active:scale-[0.98] w-full sm:w-auto shadow shadow-slate-900/10">
                Guardar Enlace Corto
            </button>
        </form>

        <!-- TOAST NOTIFICATION FLOTANTE (Alpine.js) -->
        <div class="fixed bottom-6 left-1/2 -translate-x-1/2 md:left-auto md:right-8 md:-translate-x-0 z-50 pointer-events-none"
             x-show="showToast"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 md:translate-y-0 md:translate-x-4"
             x-transition:enter-end="opacity-100 translate-y-0 md:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 md:translate-x-0"
             x-transition:leave-end="opacity-0 translate-y-4 md:translate-y-0 md:translate-x-4"
             style="display: none;">
            <div class="bg-slate-900 text-white text-xs md:text-sm font-semibold py-3.5 px-6 rounded-2xl shadow-xl flex items-center gap-2 border border-slate-800">
                <span class="text-emerald-400">✨</span>
                ¡Enlace copiado al portapapeles! Listo para compartir en Instagram.
            </div>
        </div>
    </div>
</div>

</body>
</html>
