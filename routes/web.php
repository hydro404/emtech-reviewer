<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

Route::get('/',[QuizController::class, 'index']);
Route::get('/part1',[QuizController::class, 'showPart1']);

Route::get('/part2',[QuizController::class, 'showPart2'])->name('quiz.part2.show');
Route::post('/part2/reset', [QuizController::class, 'resetPart2'])->name('quiz.part2.reset');
Route::post('/check-part2',[QuizController::class, 'checkPart2'])->name('quiz.part2.check');

Route::get('/part3', [QuizController::class, 'showPart3'])->name('quiz.part3.show');
Route::post('/part3', [QuizController::class, 'submitPart3'])->name('quiz.part3.submit');