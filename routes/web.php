<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'Registerme'])->name('register.post');

Route::get('/admin', [AdminController::class, 'showDashboard'])->name('admin.dashboard')->middleware(['auth','role:admin']);
Route::get('/admin/course_category', [AdminController::class, 'showCourseCategory'])->name('admin.course_category.manage');
Route::post('/admin/course_category', [AdminController::class, 'createCourseCategory'])->name('admin.course_category.add');

Route::get('/admin/course', [AdminController::class, 'showCourse'])->name('admin.course.manage');
Route::post('/admin/course', [AdminController::class, 'createCourse'])->name('admin.course.add');


