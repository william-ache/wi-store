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

        if (!$shop) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();

        if (! PlanFeatures::routeBlockedForShop($shop, $routeName)) {
            return $next($request);
        }

        $module = PlanFeatures::routeRequiredModule($routeName);

        return redirect()
            ->route('admin.dashboard', ['shop_slug' => $shop->slug])
            ->with('plan_module_blocked', 'El módulo «' . ($module ?? 'solicitado') . '» no está disponible en tu plan o fue desactivado por el administrador.');
    }
}
