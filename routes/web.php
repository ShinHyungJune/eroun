<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::post("/users", [\ShinHyungJune\SocialLogin\Http\UserController::class, "store"]);

Route::get('/', [\App\Http\Controllers\PageController::class, "index"])->name("home");
Route::get('/home', [\App\Http\Controllers\PageController::class, "index"])->name("home");


Route::get("/login", [\ShinHyungJune\SocialLogin\Http\UserController::class, "loginForm"]);

Route::middleware("guest")->group(function(){
    Route::get("/openLoginPop/{social}", [\ShinHyungJune\SocialLogin\Http\UserController::class, "openSocialLoginPop"]);
    Route::get("/login", [\ShinHyungJune\SocialLogin\Http\UserController::class, "index"])->name("login");
    Route::get("/login/{social}", [\ShinHyungJune\SocialLogin\Http\UserController::class, "socialLogin"]);
    Route::post("/login", [\ShinHyungJune\SocialLogin\Http\UserController::class, "login"]);
    Route::resource("/users", \ShinHyungJune\SocialLogin\Http\UserController::class);
    Route::get("/passwordResets/{token}/edit", [\ShinHyungJune\SocialLogin\Http\PasswordResetController::class, "edit"]);
    Route::resource("/passwordResets", \ShinHyungJune\SocialLogin\Http\PasswordResetController::class);
});

Route::middleware("auth")->group(function(){
    Route::get("/logout", [\ShinHyungJune\SocialLogin\Http\UserController::class, "logout"]);
});

Route::get("/mailable", function(){
    return (new \App\Mail\PasswordResetCreated(new \App\Models\User(), new \App\Models\PasswordReset()));
});


// 개발
Route::middleware("auth")->group(function(){
    Route::post("/reviews", [\App\Http\Controllers\ReviewController::class, "store"]);
    Route::get("/requests", [\App\Http\Controllers\RequestController::class, "index"]);
});

Route::get("/workers", [\App\Http\Controllers\WorkerController::class, "index"]);
Route::get("/workers/{id}", [\App\Http\Controllers\WorkerController::class, "show"]);

Route::get("/events", [\App\Http\Controllers\EventController::class, "index"]);
Route::get("/events/{id}", [\App\Http\Controllers\EventController::class, "show"]);

Route::get("/requests/create", [\App\Http\Controllers\RequestController::class, "create"]);
Route::post("/requests", [\App\Http\Controllers\RequestController::class, "store"]);
