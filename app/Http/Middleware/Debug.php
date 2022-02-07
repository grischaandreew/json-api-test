<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Barryvdh\Debugbar\Facade as Debugbar;

class Debug
{
    public function handle($request, Closure $next)
    {
        if( $request->is("_debugbar/assets/stylesheets") || $request->is("_debugbar/assets/javascript") ) {
          Debugbar::enable();
          return $next($request);
        }
        $debug = $request->get("debug");
        if (!$debug) {
          return $next($request);
        }
        Debugbar::enable();
        unset($request['debug']);
        $response = $next($request);

        // Perform action
        $renderer = Debugbar::getJavascriptRenderer();
        echo "<html>";
        echo $renderer->renderHead();
        echo "</head><body>";
        echo $renderer->render();
        echo "<pre>";
        return $response;
    }
}