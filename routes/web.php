<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\TaskController;
Use App\Http\Controllers\StudentController;
Use App\Http\Controllers\ResourcesManagerController;
Use App\Http\Controllers\MissionController;

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
Route::get('/admin/course_category/{id}/delete', [AdminController::class, 'deleteCourseCategory'])->name('admin.course_category.delete')->middleware(['auth', 'role:admin']);
Route::post('/admin/course_category/{id}', [AdminController::class, 'updateCourseCategory'])->name('admin.course_category.update')->middleware(['auth', 'role:admin']);

Route::get('/admin/course', [AdminController::class, 'showCourse'])->name('admin.course.manage')->middleware(['auth','role:admin']);
Route::post('/admin/course', [AdminController::class, 'createCourse'])->name('admin.course.add')->middleware(['auth','role:admin']);
Route::get('/admin/course/{id}', [AdminController::class, 'showCourseDetail'])->name('admin.course.detail')->middleware(['auth','role:admin']);
Route::get('/admin/course/{id}/delete', [AdminController::class, 'deleteCourse'])->name('admin.course.delete')->middleware(['auth', 'role:admin']);
Route::post('/admin/course/{id}', [AdminController::class, 'updateCourse'])->name('admin.course.update')->middleware(['auth', 'role:admin']);

Route::post('/admin/course/{id}/contents', [AdminController::class, 'createContent'])->name('admin.course.content.add')->middleware(['auth', 'role:admin']);
Route::get('/admin/contents/{id}/delete', [AdminController::class, 'deleteContent'])->name('admin.content.delete')->middleware(['auth','role:admin']);
Route::post('/admin/course/{id}/level', [LevelController::class, 'createLevel'])->name('admin.course.level.add')->middleware(['auth', 'role:admin']);
Route::post('/admin/course/{id}/berkas', [AdminController::class, 'createBerkas'])->name('admin.course.berkas.add')->middleware(['auth', 'role:admin']);

Route::post('/admin/course/{id}/soal', [SoalController::class, 'createSoal'])->name('admin.course.soal.add')->middleware(['auth', 'role:admin']);
Route::post('/admin/course/{course_id}/contents/{content_id}/task', [TaskController::class, 'createTask'])->name('admin.course.content.task.add')->middleware(['auth', 'role:admin']);

Route::get('/admin/course/{course_id}/enrollment/{id}/confirm', [AdminController::class, 'enrollmentConfirm'])->name('admin.course.enrollment.confirm')->middleware(['auth', 'role:admin']);
Route::get('/admin/course/{course_id}/enrollment/{id}/decline', [AdminController::class, 'enrollmentDecline'])->name('admin.course.enrollment.decline')->middleware(['auth', 'role:admin']);
Route::post('/admin/course/point/adjustment', [AdminController::class, 'PointAdjustment'])->name('admin.point.adjustment')->middleware(['auth', 'role:admin']);
Route::get('/berkas_pendukung/{berkas_id}/download', [ResourcesManagerController::class, 'DownloadBerkasPendukung'])->name('rmc.berkas_pendukung.download');
Route::get('/berkas_pendukung/{berkas_id}/delete', [ResourcesManagerController::class, 'DeleteBerkasPendukung'])->name('rmc.berkas_pendukung.delete')->middleware(['auth', 'role:admin']);

//mission
Route::post('/admin/mission', [MissionController::class, 'createMission'])->name('admin.mission.create')->middleware(['auth','role:admin']);
Route::get('/admin/mission', [AdminController::class, 'showMission'])->name('admin.mission.dashboard')->middleware(['auth', 'role:admin']);
//game
Route::post('/admin/game', [GameController::class, 'createGame'])->name('admin.game.create')->middleware(['auth','role:admin']);
Route::get('/student/game/{id}/tantang', [GameController::class, 'createGameSession'])->name('student.game.create.session')->middleware(['auth', 'role:student']);
Route::get('/student/game/{id}/tantang/{session_id}', [GameController::class, 'showGameSession'])->name('student.game.session')->middleware(['auth', 'role:student']);
Route::get('/student/game/{id}/tantang/{session_id}/claim', [GameController::class, 'claimGameSession'])->name('student.game.session.claim')->middleware(['auth', 'role:student']);

Route::get('/api/student/game/{id}/tantang/{session_id}', [GameController::class, 'getGameSessionActivity'])->name('api.student.game.session')->middleware(['auth', 'role:student']);
Route::post('/api/student/game/{id}/tantang/{session_id}', [GameController::class, 'createGameActivity'])->name('api.student.game.create.activity')->middleware(['auth', 'role:student']);
Route::post('/api/student/game/{id}/tantang/{session_id}/activity', [GameController::class, 'updateGameActivity'])->name('api.student.game.update.activity')->middleware(['auth', 'role:student']);


Route::get('/student', [StudentController::class, 'showDashboard'])->name('student.dashboard')->middleware(['auth','role:student']);
Route::get('/student/course/{id}', [StudentController::class, 'showCourse'])->name('student.course.detail')->middleware(['auth','role:student']);
Route::get('/student/course/{id}/enroll', [StudentController::class, 'showCourseEnroll'])->name('student.course.enroll')->middleware(['auth', 'role:student']);
Route::get('/student/course/{id}/enrollme', [StudentController::class, 'CourseEnroll'])->name('student.course.enrollme')->middleware(['auth','role:student']);

Route::get('/api/event', [MissionController::class, 'apiMission'])->name('api.mission')->middleware(['auth', 'role:student']);
Route::post('/api/event/{id}', [MissionController::class, 'apiClaimMission'])->name('api.mission.claim')->middleware(['auth', 'role:student']);
Route::get('/api/leaderboard', [StudentController::class, 'apiLeaderboard'])->name('api.leaderboard');
