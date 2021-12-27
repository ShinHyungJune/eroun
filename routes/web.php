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
Route::post("/users", [\App\Http\Controllers\UserController::class, "store"]);

Route::get('/', [\App\Http\Controllers\PageController::class, "index"])->name("home");
Route::get('/home', [\App\Http\Controllers\PageController::class, "index"]);


Route::get("/login", [\App\Http\Controllers\UserController::class, "loginForm"]);
Route::post("verifyNumbers", [\App\Http\Controllers\Api\VerifyNumberController::class, "store"]);
Route::patch("verifyNumbers", [\App\Http\Controllers\Api\VerifyNumberController::class, "update"]);

Route::middleware("auth")->group(function(){
    Route::get("/users/edit", [\App\Http\Controllers\UserController::class, "edit"]);
    Route::post("/users/update", [\App\Http\Controllers\UserController::class, "update"]);
});

Route::middleware("guest")->group(function(){
    Route::get("/openLoginPop/{social}", [\App\Http\Controllers\UserController::class, "openSocialLoginPop"]);
    Route::get("/login", [\App\Http\Controllers\UserController::class, "index"])->name("login");
    Route::get("/login/{social}", [\App\Http\Controllers\UserController::class, "socialLogin"]);
    Route::post("/login", [\App\Http\Controllers\UserController::class, "login"]);
    Route::resource("/users", \App\Http\Controllers\UserController::class);
    Route::get("/passwordResets/{token}/edit", [\ShinHyungJune\SocialLogin\Http\PasswordResetController::class, "edit"]);
    Route::resource("/passwordResets", \ShinHyungJune\SocialLogin\Http\PasswordResetController::class);
});

Route::middleware("auth")->group(function(){
    Route::get("/logout", [\App\Http\Controllers\UserController::class, "logout"]);
});

Route::get("/mailable", function(){
    return (new \App\Mail\PasswordResetCreated(new \App\Models\User(), new \App\Models\PasswordReset()));
});


// 개발
Route::middleware("auth")->group(function(){
    Route::post("/reviews", [\App\Http\Controllers\ReviewController::class, "store"]);
    Route::get("/reviews/create", [\App\Http\Controllers\ReviewController::class, "create"]);
    Route::get("/requests", [\App\Http\Controllers\RequestController::class, "index"]);
});

Route::get("/404", [\App\Http\Controllers\ErrorController::class, "notFound"]);
Route::get("/403", [\App\Http\Controllers\ErrorController::class, "unAuthenticated"]);
Route::get("/workers", [\App\Http\Controllers\WorkerController::class, "index"]);
Route::get("/workers/{id}", [\App\Http\Controllers\WorkerController::class, "show"]);

Route::get("/events", [\App\Http\Controllers\EventController::class, "index"]);
Route::get("/events/{id}", [\App\Http\Controllers\EventController::class, "show"]);

Route::get("/requests/create", [\App\Http\Controllers\RequestController::class, "create"]);
Route::post("/requests", [\App\Http\Controllers\RequestController::class, "store"]);
Route::get("/privacyPolicy", [\App\Http\Controllers\PageController::class, "privacyPolicy"]);
Route::post("/ckeditor/upload", [\App\Http\Controllers\CkeEditorController::class, "upload"])->name('ckeditor.upload');
