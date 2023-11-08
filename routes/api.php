<?php

use App\Http\Controllers\VCardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/vcard/register", [VCardController::class, "register"]);
Route::post("/vcard/login", [VCardController::class, "login"]);
