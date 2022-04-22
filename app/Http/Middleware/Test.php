<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Test
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::withCount('entreprises')->find(auth()->user()->id);
        dd($user->entreprises_count);
        if (Auth::user() && $user->entreprises_count >=1 && Route::currentRouteName() == 'entreprise' ) {
           return redirect('/welcome');
        }else {
            return $next($request);
        }
        
    }
}
