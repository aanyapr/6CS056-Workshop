
<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('/students'));

/* ---------- STUDENTS ---------- */

Route::resource('students', StudentController::class);


/* ---------- COURSES ---------- */

Route::resource('courses', CourseController::class);
