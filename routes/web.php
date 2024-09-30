<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::post('/save-fcm-token', function(Request $request) {
    $user = auth()->user();

    if ($user) {
        $user->fcm_token = $request->token;
        $user->save();
        return response()->json(['success' => true, 'message' => 'Token stored successfully']);
    }

    return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/detail/{postId}', [PostController::class, 'detail']);
Route::get('/map', function () {
    return view('map');
});
