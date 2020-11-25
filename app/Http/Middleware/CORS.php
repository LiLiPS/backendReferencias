<?php

namespace App\Http\Middleware;

use Closure;

class CORS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /*public function handle($request, Closure $next)
    {
        header('Access-Control-Allow-Origin : *');
        header('Access-Control-Allow-Headers : Content-type, X-Auth-Token, Authorization, Origin');
        header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PATCH, PUT, DELETE');
        return $next($request);
    }*/

    public function handle($request, Closure $next)
    {
        //All the domains you want to whitelist
        $trusted_domains = [
            "http://localhost:4200",
            "http://localhost",
            "http://127.0.0.1:4200"
        ];
        if (isset($request->server()['HTTP_ORIGIN'])) {
            $origin = $request->server()['HTTP_ORIGIN'];

            if (in_array($origin, $trusted_domains)) {
                header('Access-Control-Allow-Origin: ' . $origin);
                header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, X-Auth-Token,x-xsrf-token');
                header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PATCH, PUT, DELETE');
            }
        }

        return $next($request);
    }
}