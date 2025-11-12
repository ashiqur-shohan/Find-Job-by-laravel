<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;

Route::get('/',[HomeController::class, 'index'] )->name('home');

// create and add auth middleware to these routes
Route::resource('jobs', JobController::class)->middleware('auth')->only(['create','edit','update','destroy']);
// everyone can see these routes
Route::resource('jobs', JobController::class)->except(['create','edit','update','destroy']);

//Group wise guest middleware applied
Route::middleware('guest')->group(function(){
    Route::get('/register',[RegisterController::class,'register'] )->name('register');
    Route::post('/register',[RegisterController::class,'store'] )->name('register.store');
    Route::get('/login',[LoginController::class,'login'] )->name('login');
    Route::post('/login',[LoginController::class,'authenticate'] )->name('login.authenticate');
});

Route::post('/logout',[LoginController::class,'logout'] )->name('logout');

Route::get('/dashboard',[DashboardController::class,'index'] )->name('dashboard');
