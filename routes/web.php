<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjectIdeasController;
use App\Http\Controllers\PageController;
use App\Models\ProjectIdea;

Route::get('/', [PageController::class, 'showWelcomePage']);

Route::get('/about', [PageController::class, 'showAboutPage']);

Route::get('/contact', [PageController::class, 'showContactPage']);

Route::post('/contact-form', [ContactController::class, 'contactFormHandler']);


Route::get('/project-ideas', [ProjectIdeasController::class, 'index']);

Route::post('/create-idea', [ProjectIdeasController::class, 'store']);

Route::get('/project-ideas/{projectIdea}', [ProjectIdeasController::class, 'show']);

Route::get('/project-ideas/{projectIdea}/edit', [ProjectIdeasController::class, 'edit']);

Route::patch('/project-ideas/{projectIdea}', [ProjectIdeasController::class, 'update']);

Route::delete('/project-ideas/{projectIdea}', [ProjectIdeasController::class, 'destroy']);
