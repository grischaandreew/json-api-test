<?php

namespace App\Http\Middleware;

use App;
use Closure;

class Language
{
    public function handle($request, Closure $next)
    {
        $lang = $request->get("lang");
        if ( $lang ) {
          App::setLocale($lang);
          config(['translatable.locale' => $lang]);
        }
        return $next($request);
    }
}