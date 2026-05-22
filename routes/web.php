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
            if ($shop->plan === 'standard') {
                $shop->active_session_id = $request->session()->getId();
                $shop->save();
            }
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
    $user = Illuminate\Support\Facades\Auth::user();
    if ($user && $user->shop_id) {
        $shop = \App\Models\Shop::find($user->shop_id);
        if ($shop && $shop->plan === 'standard' && $shop->active_session_id === $request->session()->getId()) {
            $shop->active_session_id = null;
            $shop->save();
        }
    }

    Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Illuminate\Http\Request $request) {
    $request->validate([
        'shop_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'color_primary' => 'required|string|max:20',
        'color_accent' => 'required|string|max:20',
        'color_bg' => 'required|string|max:20',
    ]);

    // Generar slug único
    $slug = Illuminate\Support\Str::slug($request->shop_name);
    $originalSlug = $slug;
    $count = 1;
    while (\App\Models\Shop::where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $count++;
    }

    // Crear la tienda
    $shop = \App\Models\Shop::create([
        'name' => $request->shop_name,
        'slug' => $slug,
        'whatsapp_number' => '0000000000', // Default placeholder
        'color_primary' => $request->color_primary,
        'color_secondary' => $request->color_accent, // Map HTML color_accent to database color_secondary
        'color_background' => $request->color_bg, // Map HTML color_bg to database color_background
        'plan' => 'premium', // Trial starts on Plan Premium
        'billing_cycle' => 'mensual',
        'plan_expires_at' => now()->addDays(7)->format('Y-m-d'),
        'last_payment_date' => now()->format('Y-m-d'),
        'last_payment_amount' => 0.00,
        'is_active' => true,
        'shop_category' => 'otros',
        'shop_category_icon' => '📦',
    ]);

    // Crear el usuario administrador
    $user = \App\Models\User::create([
        'shop_id' => $shop->id,
        'name' => 'Administrador de ' . $shop->name,
        'email' => $request->email,
        'password' => Illuminate\Support\Facades\Hash::make($request->password),
        'temp_password' => $request->password, // Save raw password as a reference
    ]);

    // Crear una notificación interna de bienvenida
    \App\Models\Notification::create([
        'shop_id' => $shop->id,
        'title' => '¡Bienvenido a WIStore!',
        'content' => 'Tu tienda ha sido creada con éxito. Estás disfrutando de 7 días de prueba gratis del Plan Premium. Puedes personalizar tu tienda en Configuración.',
        'type' => 'billing',
        'is_read' => false,
    ]);

    // Autenticar automáticamente al usuario
    Illuminate\Support\Facades\Auth::login($user);

    // Redirigir al panel de administración
    return redirect()->route('admin.dashboard', ['shop_slug' => $shop->slug]);
})->name('register.submit');


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
        
        // Rutas de administración de pagos
        Route::post('/payments/{id}/approve', [App\Http\Controllers\SuperAdminController::class, 'approvePayment'])->name('payments.approve');
        Route::post('/payments/{id}/reject', [App\Http\Controllers\SuperAdminController::class, 'rejectPayment'])->name('payments.reject');
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
        
        // Rutas de Facturación y Suscripción Expirada
        Route::get('/billing/expired', [App\Http\Controllers\Admin\BillingController::class, 'expired'])->name('billing.expired');
        Route::post('/billing/pay', [App\Http\Controllers\Admin\BillingController::class, 'submitPayment'])->name('billing.pay');
        
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
