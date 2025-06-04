<?php

use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AIController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/dashboard', function () {
        $authUser = User::find(auth()->id());
        if ($authUser->user_roles == 'teacher') {
            $lessons=Lesson::where('created_by',$authUser);             
        }
        else{
            $lessons=Lesson::all(); 
        }
        $user_role = auth()->user()->user_roles;
    return Inertia::render('Dashboard',[
        'lessons' => $lessons,
        'user_role' => $user_role,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/lessons/create', [LessonController::class, 'create'])->name('lessons.create')->middleware('staff');
    Route::post('/lessons', [LessonController::class, 'store'])->name('lessons.store')->middleware('staff');
    Route::get('/lessons/{id}', [LessonController::class, 'show'])->name('lessons.show') ;

    Route::get('users', [\App\Http\Controllers\AdminController::class, 'allUsers'])->name('users.all')->middleware('admin');
    Route::get('user/{id}/edit', [\App\Http\Controllers\AdminController::class, 'editShow'])->name('users.edit')->middleware('admin');
    Route::put('user/{id}/edit', [\App\Http\Controllers\AdminController::class, 'edit'])->name('users.update')->middleware('admin');
    Route::delete('user/{id}/delete', [\App\Http\Controllers\AdminController::class, 'delete'])->name('users.delete')->middleware('admin');

    // Route::post('/chat', ChatController::class);

Route::post('/generate', [ChatController::class, 'generate']);

    
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
