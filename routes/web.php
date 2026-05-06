<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjectIdeasController;
use App\Http\Controllers\PageController;

Route::get('/', [PageController::class, 'showWelcomePage']);

Route::get('/about', [PageController::class, 'showAboutPage']);

Route::get('/contact', [PageController::class, 'showContactPage']);

Route::post('/contact-form', [ContactController::class, 'contactFormHandler']);

Route::get('/project-ideas', [ProjectIdeasController::class, 'showIdeasPage']);

Route::post('/create-idea', [ProjectIdeasController::class, 'createIdea']);

