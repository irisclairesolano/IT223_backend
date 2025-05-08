<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class EncryptCookies
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Encrypt cookies here (if any need encryption)
        foreach ($request->cookies as $key => $value) {
            // This could be an example, you might need to adapt encryption logic
            $response->headers->setCookie(cookie()->forever($key, Crypt::encrypt($value)));
        }

        return $response;
    }
}
