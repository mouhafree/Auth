<?php


use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\JsonResponse;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::any('/students', [StudentController::class, 'students']);
// use App\Http\Controllers\StudentController;
// routes/api.php



Route::get('/getAllNotes', [StudentController::class, 'getAllNotes']);


Route::get('/getNotes/{id}', [StudentController::class, 'getNotes']);

Route::get('/assign-grade/{studentId}/', [StudentController::class, 'assignGrade']);
Route::post('/addNoteStudent/{id}', [StudentController::class, 'addNoteStudent']);

Route::post('/addNoteStudents/{id}', [StudentController::class, 'addNoteStudents']);

Route::post('/students', [StudentController::class, 'students']);
Route::get('/students', [StudentController::class, 'getStudents']);


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

// Route::post('/logout', [UserController::class, 'logout']);
// ::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);
