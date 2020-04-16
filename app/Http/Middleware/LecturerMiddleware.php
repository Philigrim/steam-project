<?php

namespace App\Http\Middleware;

use Closure;

class LecturerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if(\Auth::check() && (\Auth::user()->isRole()=="paskaitu_lektorius" || \Auth::user()->isRole()=="admin")){
            return $next($request);
        }

        return redirect('about');
    }
}
