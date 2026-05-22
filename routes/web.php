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
    if (Illuminate\Support\Facades\Auth::check()) {
        $user = Illuminate\Support\Facades\Auth::user();
        $shop = \App\Models\Shop::find($user->shop_id);
        if ($shop) {
            return redirect()->route('admin.dashboard', ['shop_slug' => $shop->slug]);
        }
    }
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
    return view('auth.register');
})->name('register');


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

// Rutas de Super Administrador (Oculto)
Route::prefix('/wydex-super-admin')->name('super-admin.')->group(function () {
    // Rutas públicas de Login
    Route::get('/login', [App\Http\Controllers\SuperAdminController::class, 'showLoginForm'])->name('login-form');
    Route::post('/login', [App\Http\Controllers\SuperAdminController::class, 'login'])->name('login');

    // Rutas protegidas bajo autenticación
    Route::middleware(['super_admin_auth'])->group(function () {
        Route::get('/', [App\Http\Controllers\SuperAdminController::class, 'index'])->name('index');
        Route::post('/shops', [App\Http\Controllers\SuperAdminController::class, 'store'])->name('shops.store');
        Route::post('/shops/{id}/toggle', [App\Http\Controllers\SuperAdminController::class, 'toggleStatus'])->name('shops.toggle');
        Route::put('/shops/{id}', [App\Http\Controllers\SuperAdminController::class, 'update'])->name('shops.update');
        Route::post('/logout', [App\Http\Controllers\SuperAdminController::class, 'logout'])->name('logout');
    });
});

// 2. RUTAS DINÁMICAS MULTI-TENANT (Tiendas Individuales)
// Colocadas al final del archivo. La detección y el aislamiento ocurren mediante el Middleware 'tenant'.
Route::middleware(['tenant'])->group(function () {

    // Frontend del Cliente (Público)
    Route::get('/{shop_slug}', [StoreController::class, 'index'])->name('store.index');
    Route::post('/{shop_slug}/reviews', [StoreController::class, 'storeReview'])->name('reviews.store');
    Route::post('/{shop_slug}/clients/quick-register', [StoreController::class, 'registerClient'])->name('clients.quick-register');
    Route::post('/{shop_slug}/orders/notify', [StoreController::class, 'notifyOrder'])->name('orders.notify');
    
    // Panel Administrativo de la Tienda (Privado)
    Route::middleware(['auth'])->prefix('/{shop_slug}/admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/search', [App\Http\Controllers\Admin\DashboardController::class, 'search'])->name('search');
        
        // Perfil de Tienda y Configuración Visual
        Route::get('/settings', [ShopSettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [ShopSettingsController::class, 'update'])->name('settings.update');
        Route::post('/settings/resolve-url', [ShopSettingsController::class, 'resolveShortUrl'])->name('settings.resolve-url');
        Route::post('/settings/short-link', [ShortLinkController::class, 'store'])->name('settings.short-link');

        // API de Notificaciones
        Route::get('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/{id}/read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::delete('/notifications/{id}', [App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::delete('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');

        // CRUDs de Categorías, Productos, Órdenes y Clientes
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
        Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
        Route::resource('clients', App\Http\Controllers\Admin\ClientController::class);
    });
});
