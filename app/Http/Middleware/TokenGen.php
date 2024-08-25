<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenGen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userName = $request->username;
        $password = $request->password;

      $user=User::where('name',$userName)->first();

  //dd($user);
        if ($user->password != $request->password){
         
            return response()->json('Unauthorized!', 401);
        }
       
        return $next($request);
    }
}
