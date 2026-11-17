<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('welcome');
Route::inertia('/home', 'Home')->name('home');
