<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Trigger newsletter send once (for testing without scheduler). Remove or protect in production.
Route::get('/newsletter/send-now', function () {
    Artisan::call('newsletter:send-monthly');
    $output = Artisan::output();
    return response()->json(['message' => 'Newsletter send completed.', 'output' => trim($output)]);
});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/courses', function () {
        return Inertia::render('CourseDetail');
    })->name('courses');
});

require __DIR__.'/auth.php';
