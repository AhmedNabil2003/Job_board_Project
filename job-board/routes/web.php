<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// الصفحة الرئيسية
Route::get('/', function () {
    return view('home.home');
})->name('home');

// مسارات تسجيل الدخول
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// مسارات التسجيل
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// مسارات لوحة التحكم
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// مسارات الوظائف
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{id}', [JobController::class, 'details'])->name('jobs.details');
Route::get('/jobs/post', [JobController::class, 'create'])->name('jobs.create');
Route::post('/jobs/store', [JobController::class, 'store'])->name('jobs.store');

// مسارات الطلبات
Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
Route::post('/applications/{id}/approve', [ApplicationController::class, 'approve'])->name('applications.approve');

// مسارات الملفات الشخصية
Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
// routes/web.php
Route::put('/profile/{id}/update', [ProfileController::class, 'update'])->name('profile.update');



Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // مسار تعديل المستخدم
    // مسار تحديث المستخدم
    Route::get('/admin/user/edit/{id}', [AdminController::class, 'editUser'])->name('admin.edit_user');
    Route::post('/admin/user/update/{id}', [AdminController::class, 'updateUser'])->name('admin.update_user');
    Route::post('/admin/user/notify/{id}', [AdminController::class, 'notifyUser'])->name('admin.notify_user');
    Route::post('/admin/user/delete/{id}', [AdminController::class, 'destroy'])->name('admin.delete_user');
    Route::patch('/admin/user/activate/{id}', [AdminController::class, 'activateUser'])->name('admin.activate_user');
    Route::patch('/admin/users/{id}/deactivate', [AdminController::class, 'deactivateUser'])->name('admin.deactivate_user');
    Route::get('/admin/manage_jobs', [AdminController::class, 'manageJobs'])->name('admin.manage_jobs');
    Route::get('/admin/manage_users', [AdminController::class, 'manageUsers'])->name('admin.manage_users');
    // مسار الموافقة على الوظيفة

});
// مسارات الإدارة
// مسارات المرشحين
Route::get('/candidate/dashboard', [CandidateController::class, 'dashboard'])->name('candidate.dashboard')->middleware('role:candidate');
Route::get('/candidates/saved_jobs', [CandidateController::class, 'savedJobs'])->name('candidate.savedjobs');
// مسارات أصحاب العمل
Route::get('/employer/dashboard', [EmployerController::class, 'dashboard'])->name('employer.dashboard')->middleware('role:employer');
Route::get('/employers/job_listings', [EmployerController::class, 'jobListings'])->name('employer.job_listings');

// مسارات الإشعارات
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

// مسارات الرسائل (إذا كنت تستخدمها)
Route::get('/messages/inbox', [MessageController::class, 'inbox'])->name('messages.inbox');
Route::get('/messages/conversation/{id}', [MessageController::class, 'conversation'])->name('messages.conversation');

// تسجيل الخروج
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
