<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\logicalOr;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiToken = $request->token;
       
        $checkToken = User::where('name',$request->name)->first();
       // dd($checkToken);
      // dd($apiToken);
      // dd($checkToken->remember_token);
        if ($apiToken != $checkToken->remember_token){
         
            return response()->json('Unauthorized!', 401);
        }
        return $next($request);
    }
}
