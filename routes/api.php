<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApiToken;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::middleware('token_gen')->post('/token', function (Request $request) {
    $uhash=Hash::make($request->username);
    $phash=Hash::make($request->password);
    $token= Str::random(60);
    $user = User::where('name',$request->username)->first();
    //dd($user);
    $user->remember_token=$token;

    $user->save();
    return response()->json([
        'username'=>$request->username,
        'api_token'=> $token,
    ]);
});


Route::middleware('api_token')->get('/data', function (Request $request) {
    
    $name = $request->query('name');

    return response()->json([

        'name' => $name,
    ]);
});

