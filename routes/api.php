<?php

use App\Http\Controllers\NotebookController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\NoteTagController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// private routes
Route::middleware('auth:sanctum')->group(function () {

    Route::delete('logout', [AuthController::class, 'logout']);

    Route::resource('notebooks', NotebookController::class);
    Route::resource('notes', NoteController::class);
    Route::resource('tags', TagController::class);

    Route::post('note_tag', [NoteTagController::class, 'store']);
    Route::delete('note_tag', [NoteTagController::class, 'destroy']);


});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
