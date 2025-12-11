<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;

class TenantMiddleware
{
    public function handle($request, Closure $next)
    {
        dd(2345);
        // $subdomain = explode('.', $request->getHost())[0];

        // $tenant = Tenant::where('subdomain', $subdomain)->first();

        // if (!$tenant) {
        //     return response()->json(['message' => 'Invalid school domain'], 404);
        // }

        // app()->instance('tenant', $tenant);

        return $next($request);
    }
}
