<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


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

        Log::channel('api_requests')->info('API Request', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'token' => $request->token,
            'mac'=>$request->mac,
            'payload' => $request->all(),
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'token' => 'required|string',
            
        ]);
        $apiToken = $request->token;
       
        $checkToken = User::where('name',$request->name)->first();
       // dd($checkToken);
      // dd($apiToken);
      // dd($checkToken->remember_token);
        if ($apiToken != $checkToken->api_token){
           
         
            return response()->json('Unauthorized!', 401);
        }
        return $next($request);
    }
}
