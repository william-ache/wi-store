<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Admin\ShopSettingsController;
use App\Http\Controllers\ShortLinkController;

// 1. RUTAS ESTÁTICAS DE LA PLATAFORMA SAAS (WIStore)
// Definidas en el primer nivel para evitar que colisionen con las rutas dinámicas.
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Illuminate\Support\Facades\Auth::attempt($credentials, $request->has('remember'))) {
        $request->session()->regenerate();

        $user = Illuminate\Support\Facades\Auth::user();
        $shop = \App\Models\Shop::find($user->shop_id);
        if ($shop) {
            return redirect()->route('admin.dashboard', ['shop_slug' => $shop->slug]);
        }
        
        Illuminate\Support\Facades\Auth::logout();
        return back()->withErrors([
            'email' => 'El usuario no está asociado a ninguna tienda activa.',
        ])->onlyInput('email');
    }

    return back()->withErrors([
        'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
    ])->onlyInput('email');
});

Route::any('/logout', function (Illuminate\Http\Request $request) {
    Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/register', function () {
    return '<div style="font-family:sans-serif; text-align:center; padding: 4rem;"><h2>Módulo de Registro de Tiendas</h2><p>El portal donde los emprendedores se registran y crean su tienda en segundos.</p><a href="/">Volver al Inicio</a></div>';
})->name('register');

Route::get('/demo-custom', function () {
    return '<div style="font-family:sans-serif; text-align:center; padding: 4rem; background-color: #0b0f19; color: #f3f4f6; min-h-screen: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center;"><h2 style="font-size: 2.25rem; font-weight: 900; color: #f59e0b; margin-bottom: 1rem;">Ecosistema WICustom Independiente</h2><p style="color: #9ca3af; max-width: 28rem; line-height: 1.625; margin-bottom: 2rem;">Esta demostración simula un entorno totalmente dedicado e independiente de software a la medida, alojado fuera del servidor compartido de WIStore.</p><a href="/" style="background-color: #f59e0b; color: #0b0f19; font-weight: 800; padding: 0.875rem 2rem; border-radius: 0.75rem; text-decoration: none; font-size: 0.875rem; transition: background-color 0.2s;">Volver al Inicio</a></div>';
})->name('demo.custom');

Route::get('/demo-wilink', function () {
    return view('demo.wilink');
})->name('demo.wilink');

// Ruta de Comparativa Técnica de Planes
Route::get('/comparativa', function () {
    return view('planes.comparativa');
})->name('planes.comparativa');

// Ruta de Políticas y Privacidad
Route::get('/privacidad', function () {
    return view('legal.privacidad');
})->name('legal.privacidad');

// Ruta de Contacto y Soporte
Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');



// Ruta del Acortador Dinámico Interno (Ubicado antes del slug dinámico)
Route::get('/l/{code}', [ShortLinkController::class, 'redirect'])->name('short.link');

// 2. RUTAS DINÁMICAS MULTI-TENANT (Tiendas Individuales)
// Colocadas al final del archivo. La detección y el aislamiento ocurren mediante el Middleware 'tenant'.
Route::middleware(['tenant'])->group(function () {
    // Auto-login de desarrollo para poder probar el panel de administración localmente
    if (app()->environment('local') && !Illuminate\Support\Facades\Auth::check()) {
        if ($user = \App\Models\User::first()) {
            Illuminate\Support\Facades\Auth::login($user);
        }
    }

    // Frontend del Cliente (Público)
    Route::get('/{shop_slug}', [StoreController::class, 'index'])->name('store.index');
    Route::post('/{shop_slug}/reviews', [StoreController::class, 'storeReview'])->name('reviews.store');
    
    // Panel Administrativo de la Tienda (Privado)
    Route::middleware(['auth'])->prefix('/{shop_slug}/admin')->name('admin.')->group(function () {
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
        
        // Perfil de Tienda y Configuración Visual
        Route::get('/settings', [ShopSettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [ShopSettingsController::class, 'update'])->name('settings.update');
        Route::post('/settings/short-link', [ShortLinkController::class, 'store'])->name('settings.short-link');

        // CRUDs de Categorías, Productos, Órdenes y Clientes
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
        Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
        Route::resource('clients', App\Http\Controllers\Admin\ClientController::class);
    });
});
