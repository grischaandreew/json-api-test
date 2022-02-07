<?php
namespace App\Http\Middleware;

use App;
use Closure;
use Log;

class Authorize
{
    public function handle($request, Closure $next)
    {
        if ($request->isMethod("get") || $request->isMethod("head")) {
            return $next($request);
        }
        
        $isEditor = $request->headers->get("X-User-is-Editor");
        $ciamUid = $request->headers->get("X-User-Ciam-Uid");
        
        Log::debug("Middleware.Authenticate", [
          'isEditor' => $isEditor,
          'ciamUid'  => $ciamUid,
          'path'     => $request->path(),
          'method'   => $request->method()
        ]);
        
        if (!$ciamUid) {
            return response()->json(array(
            'status' => 401,
            'msg' => 'User is not logged in.'
          ), 401);
        }  
        if (!$isEditor) {
            return response()->json(array(
            'status' => 401,
            'msg' => $ciamUid ? 'User with ciam_uid "'.$ciamUid.'" has no editor role.' : 'User is not logged in.'
          ), 401);
        }
        
        return $next($request);
    }
}
