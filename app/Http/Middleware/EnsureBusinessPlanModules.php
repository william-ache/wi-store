<?php

namespace App\Http\Middleware;

use App\Support\PlanFeatures;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBusinessPlanModules
{
    public function handle(Request $request, Closure $next): Response
    {
        $shop = config('current_shop');

        if (!$shop || PlanFeatures::hasBusinessPanel($shop)) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();

        if (!PlanFeatures::routeRequiresBusinessPanel($routeName)) {
            return $next($request);
        }

        return redirect()
            ->route('admin.dashboard', ['shop_slug' => $shop->slug])
            ->with('plan_module_blocked', 'Este módulo está incluido en el Plan Negocio. Actualiza tu suscripción para acceder.');
    }
}
