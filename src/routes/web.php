<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampingController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


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
Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice')->middleware('auth');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/');
    })->middleware('auth', 'signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware('auth', 'throttle:6,1')->name('verification.send');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/', [StampingController::class, 'index']);
    Route::post('/workin', [StampingController::class, 'workIn']);
    Route::post('/workout', [StampingController::class, 'workOut']);
    Route::post('/breakingin', [StampingController::class, 'breakingIn']);
    Route::post('/breakingout', [StampingController::class, 'breakingOut']);
    Route::get('/attendance', [AttendanceController::class, 'attendance'])->name('attendance');
    Route::get('/user', [AttendanceController::class, 'user']);
    Route::get('/user/attendance/{id}', [AttendanceController::class, 'userAttendance'])->name('user.attendance');

});
