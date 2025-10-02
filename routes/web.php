<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LevelController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'Registerme'])->name('register.post');

Route::get('/admin', [AdminController::class, 'showDashboard'])->name('admin.dashboard')->middleware(['auth','role:admin']);
Route::get('/admin/course_category', [AdminController::class, 'showCourseCategory'])->name('admin.course_category.manage')->middleware(['auth','role:admin']);
Route::post('/admin/course_category', [AdminController::class, 'createCourseCategory'])->name('admin.course_category.add')->middleware(['auth','role:admin']);

Route::get('/admin/course', [AdminController::class, 'showCourse'])->name('admin.course.manage')->middleware(['auth','role:admin']);
Route::post('/admin/course', [AdminController::class, 'createCourse'])->name('admin.course.add')->middleware(['auth','role:admin']);
Route::get('/admin/course/{id}', [AdminController::class, 'showCourseDetail'])->name('admin.course.detail')->middleware(['auth','role:admin']);
Route::post('/admin/course/{id}/contents', [AdminController::class, 'createContent'])->name('admin.course.content.add')->middleware(['auth', 'role:admin']);
Route::get('admin/contents/{id}/delete', [AdminController::class, 'deleteContent'])->name('admin.content.delete')->middleware(['auth','role:admin']);
Route::post('admin/course/{id}/level', [LevelController::class, 'createLevel'])->name('admin.course.level.add')->middleware(['auth', 'role:admin']);
