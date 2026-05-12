<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return view("welcome");
})->name("home");

Route::middleware("guest")->group(function () {
    Route::get("/register", [AuthController::class, "showRegister"])->name(
        "register",
    );
    Route::post("/register", [AuthController::class, "register"]);
    Route::get("/login", [AuthController::class, "showLogin"])->name("login");
    Route::post("/login", [AuthController::class, "login"]);
});

Route::post("/logout", [AuthController::class, "logout"])
    ->middleware("auth")
    ->name("logout");

Route::middleware("auth")->group(function () {
    Route::get("/dashboard", [ApplicationController::class, "index"])->name(
        "dashboard",
    );
    Route::get("/applications/create", [
        ApplicationController::class,
        "create",
    ])->name("applications.create");
    Route::post("/applications", [ApplicationController::class, "store"])->name(
        "applications.store",
    );
    Route::patch("/applications/{application}/review", [
        ApplicationController::class,
        "updateReview",
    ])->name("applications.review");
});

Route::middleware(["auth", "admin"])
    ->prefix("admin")
    ->name("admin.")
    ->group(function () {
        Route::get("/", [ApplicationController::class, "adminIndex"])->name(
            "index",
        );
        Route::patch("/applications/{application}/status", [
            ApplicationController::class,
            "updateStatus",
        ])->name("applications.status");
    });
