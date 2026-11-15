<?php

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

Route::get('/', fn () => redirect('/students'));

// READ: list all students
Route::get('/students', function () {
    return view('student.list', ['students' => Student::all()]);
})->name('students.index');

// CREATE: show the empty form
Route::get('/students/create', function () {
    return view('student.create');
});

// CREATE: validate and save
Route::post('/students', function (Request $request) {
    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => 'required|email|max:255|unique:students,email',
        'phone'         => 'required|string|max:20',
        'address'       => 'nullable|string|max:500',
        'date_of_birth' => 'nullable|date',
    ]);

    $student = Student::create($validated);

    return redirect()->route('students.index')
        ->with('success', "Student {$student->name} created successfully!");
});

// READ: one student
Route::get('/students/{id}', function ($id) {
    return view('student.detail', ['student' => Student::findOrFail($id)]);
});

// UPDATE: show form filled with current data
Route::get('/students/{id}/edit', function ($id) {
    return view('student.edit', ['student' => Student::findOrFail($id)]);
});

// UPDATE: validate and save
Route::put('/students/{id}', function (Request $request, $id) {
    $student = Student::findOrFail($id);

    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => ['required', 'email', 'max:255',
                            Rule::unique('students')->ignore($student->id)],
        'phone'         => 'required|string|max:20',
        'address'       => 'nullable|string|max:500',
        'date_of_birth' => 'nullable|date',
    ]);

    $student->update($validated);

    return redirect('/students/' . $student->id)
        ->with('success', 'Student updated successfully!');
});

// DELETE
Route::delete('/students/{id}', function ($id) {
    Student::findOrFail($id)->delete();

    return redirect('/students')->with('success', 'Student deleted successfully!');
});
