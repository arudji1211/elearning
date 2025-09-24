<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/admin', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
Route::get('/admin/course_category', [AdminController::class, 'showCourseCategory'])->name('admin.course_category.manage');
Route::post('/admin/course_category', [AdminController::class, 'createCourseCategory'])->name('admin.course_category.add');

