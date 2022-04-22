<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class FinalisationInscription
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
    //     $user = User::withCount('entreprises')->find(auth()->user()->id);
    //     if (Auth::user() && $user->entreprises_count <= 0 && Route::currentRouteName() !== 'entreprise' ) {
    //        return redirect('/entreprise');

    // }else {
    //         return $next($request);
    //     }
        
    }
}
