<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\JobApplicationController;
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


// Route Home

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route page about
Route::get('/about', function () {
    return view('home.about');
});

// Route page contact
Route::get('/contact', function () {
    return view('home.contact');
});

// Route page help
Route::get('/help', function () {
    return view('home.help');
});

// Route page features
Route::get('/features', function () {
    return view('home.features');
});
// Routes login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Routes register
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Route dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Routes jobs
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{id}', [JobController::class, 'details'])->name('jobs.show');
Route::get('/jobs/post', [JobController::class, 'create'])->name('jobs.create');
Route::post('/jobs/store', [JobController::class, 'store'])->name('jobs.store');
Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');
Route::get('/candidates/saved_jobs', [JobController::class, 'savedJobs'])->name('candidate.savedjobs');
Route::post('/jobs/save', [JobController::class, 'saveJob'])->name('save.job');
Route::delete('/candidates/saved_jobs/unsave/{job}', [JobController::class, 'unsaveJob'])->name('jobs.unsave');

// Routes profile 
Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/{id}/update', [ProfileController::class, 'update'])->name('profile.update');


// Routes admin

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // manage users
    Route::get('/admin/manage_users', [AdminController::class, 'manageUsers'])->name('admin.manage_users');
    Route::get('/admin/user/edit/{id}', [AdminController::class, 'editUser'])->name('admin.edit_user');
    Route::put('/admin/user/update/{id}', [AdminController::class, 'updateUser'])->name('admin.update_user');
    Route::post('/admin/user/notify/{id}', [AdminController::class, 'notifyUser'])->name('admin.notify_user');
    Route::delete('/admin/user/delete/{id}', [AdminController::class, 'destroyUser'])->name('admin.delete_user');
    Route::patch('/admin/user/activate/{id}', [AdminController::class, 'activateUser'])->name('admin.activate_user');
    Route::patch('/admin/users/{id}/deactivate', [AdminController::class, 'deactivateUser'])->name('admin.deactivate_user');
    // manage jobs
    Route::get('/admin/manage_jobs', [AdminController::class, 'manageJobs'])->name('admin.manage_jobs');
    Route::get('/admin/job/edit/{id}', [AdminController::class, ' editJob'])->name('admin.edit_job');
    Route::delete('/admin/job/delete/{id}', [AdminController::class, 'destroyJob'])->name('admin.delete_job');
    Route::put('/admin/job/update/{id}', [AdminController::class, 'updateJob'])->name('admin.update_job');
    Route::get('/admin/job/view/{id}', [AdminController::class, 'viewJob']);
    // mangae categories
    Route::get('/admin/manage_categories', [AdminController::class, 'manageCategories'])->name('manage_categories');
    Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('store_category');
    Route::put('/admin/categories/{category}', [AdminController::class, 'updateCategory'])->name('update_category');
    Route::delete('/admin/categories/{category}', [AdminController::class, 'destroyCategory'])->name('delete_category');
    // settings
    Route::get('/admin/settings', [AdminController::class, 'logo'])->name('admin.settings');
    Route::post('/admin/settings/update', [AdminController::class, 'updateSettings'])->name('admin.updateSettings');
    Route::delete('/admin/delete-account/{id}', [AdminController::class, 'deleteAccount'])->name('admin.deleteAccount');
});


// Routes candidates
Route::middleware(['auth', 'role:candidate'])->group(function () {
    Route::get('/candidate/dashboard', [CandidateController::class, 'dashboard'])->name('candidate.dashboard')->middleware('role:candidate');
    Route::get('/candidates/saved_jobs', [CandidateController::class, 'savedJobs'])->name('candidate.savedjobs');
    Route::get('/candidates//resume', [ResumeController::class, 'show'])->name('resume.show');
    Route::post('/resume/upload', [ResumeController::class, 'upload'])->name('resume.upload');
    Route::get('/candidates/settings', [CandidateController::class, 'show'])->name('candidate.settings');
    Route::delete('/candidates/delete-account/{id}', [CandidateController::class, 'deleteAccount'])->name('candidate.deleteAccount');
    Route::get('/candidate/messages', [CandidateController::class, 'showMessages'])->name('candidate.messages');
    Route::get('/candidates/show_application', [CandidateController::class, 'showPageApp'])
        ->name('applications.show');

});



// Routes employers
Route::middleware(['auth', 'role:employer'])->group(function () {
    Route::get('/employers/dashboard', [EmployerController::class, 'index'])->name('employer.dashboard');
    Route::get('/employers/job_listings', [EmployerController::class, 'jobListings'])->name('employer.job_listings');
    Route::get('/employers/manage_jobs', [EmployerController::class, 'manageJobs'])->name('employer.manage_jobs');
    Route::get('/employers/job/edit/{id}', [EmployerController::class, 'editJob'])->name('employer.edit_job');
    Route::put('/employers/job/update/{id}', [EmployerController::class, 'updateJob'])->name('employer.update_job');
    Route::delete('/employers/job/delete/{id}', [EmployerController::class, 'destroyJob'])->name('employer.delete_job');
    Route::get('/employers/create_jobs', [EmployerController::class, 'showCreate'])->name('employer.create_jobs');
    Route::post('/employers/create_jobs', [EmployerController::class, 'create'])->name('employer.store_jobs');
    Route::get('/employers/job/view/{id}', [EmployerController::class, 'viewJob'])->name('employer.view_job');
    Route::get('/employers/settings', [EmployerController::class, 'show'])->name('employer.settings');
    Route::delete('/employers/delete-account/{id}', [EmployerController::class, 'deleteAccount'])->name('employer.deleteAccount');
    Route::get('/employers/show_application/{id}', [EmployerController::class, 'showApplication'])
    ->name('application_candidate.show');
    Route::get('/employers/show_application', [EmployerController::class, 'showPageApp'])
        ->name('allapplications.show');
        Route::post('/applications/{id}/accept', [EmployerController::class, 'acceptApplication'])->name('applications.accept');


});

// Routes applications
Route::get('/apply/{job}', [JobApplicationController::class, 'showForm'])->name('job.apply');
Route::post('/candidates/job-application/apply/{job}', [JobApplicationController::class, 'submitApplication'])->name('job.apply.submit');
Route::get('/candidates/show_application/{id}', [JobApplicationController::class, 'showApplication'])
->name('application.show');


// Route logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
