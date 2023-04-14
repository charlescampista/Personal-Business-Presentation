<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SociaMediaController;
use App\Http\Controllers\ExternalServicesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

// Route::controller(ProjectController::class)->group(function(){
//     Route::post('register', 'register');
//     Route::post('login', 'login');
// });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });









// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Public routes
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);


Route::get("/", function() {
    return response()->json(['message' => 'Please make the login'],200);
});

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    //WEBSITE ROUTES
    Route::get('/websites', [WebsiteController::class, 'index']);
    Route::post('/websites', [WebsiteController::class, 'store']);
    Route::get('/websites/{id}', [WebsiteController::class, 'show']);
    Route::put('/websites/{id}', [WebsiteController::class, 'edit']);
    Route::delete('/websites/{id}', [WebsiteController::class, 'destroy']);

    //PROJECT ROUTES
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    Route::put('/projects/{id}', [ProjectController::class, 'edit']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

    //CONTACT ROUTES
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::post('/contacts', [ContactController::class, 'store']);
    Route::get('/contacts/{id}', [ContactController::class, 'show']);
    Route::put('/contacts/{id}', [ContactController::class, 'edit']);
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);

    //SOCIAL MEDIA ROUTES
    Route::get('/socialmedia', [SociaMediaController::class, 'index']);
    Route::post('/socialmedia', [SociaMediaController::class, 'store']);
    Route::get('/socialmedia/{id}', [SociaMediaController::class, 'show']);
    Route::put('/socialmedia/{id}', [SociaMediaController::class, 'edit']);
    Route::delete('/socialmedia/{id}', [SociaMediaController::class, 'destroy']);

    //USER ROUTES
    Route::get('/users', [UserController::class,'index']);
    Route::put('/users/{id}', [UserController::class, 'edit']);

    //QRCODE ROUTES
    Route::get('/qrcode/{id}', [ExternalServicesController::class, 'getQrCode']);

    //AUTH ROUTES
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
});
