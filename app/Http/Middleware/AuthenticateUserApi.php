<?php

//AuthenticateSeller.php

namespace App\Http\Middleware;

use Closure;

//Auth Facade
use Illuminate\Support\Facades\Auth;

class AuthenticateUserApi
{
   public function handle($request, Closure $next)
   {
       //If request does not comes from logged in seller
       //then he shall be redirected to Seller Login page
       if (Auth::guard('usuarios')->check()) {
           return redirect('/api/login');
       }

       return $next($request);
   }
}
