<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AdminMiddelware
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
         if (@Auth::user()->user_type==1||@Auth::user()->user_type==3) {
                return $next($request);
             }else{
                return redirect('login');
             }
    }
}
