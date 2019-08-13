<?php

namespace App\Http\Middleware;

use Closure;

// Rationale: https://developerjack.com/blog/2018/laravel-resource-and-subdomain-routes/
// https://stackoverflow.com/a/31868954/5525721
class SubDomainResolution
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Set defaults for use with route() helpers.
        \URL::defaults([
            'tenant' => $request->route()->parameter('tenant'),
        ]);

        // Remove these params so they aren't passed to controllers.
        $request->route()->forgetParameter('tenant');

        return $next($request);
    }
}
