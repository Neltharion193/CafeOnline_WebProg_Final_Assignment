<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManageMiddleware
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
        $user = Session::get('usersession', "default");

        if($user["user_type_id"] == 3) {
            return redirect('/home')->with('message', 'Only Admin or Staff can accessed this page!');
        }

        return $next($request);
    }
}
