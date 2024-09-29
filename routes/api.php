<?php

use App\Http\Controllers\FeedbackFormController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/form', [FeedbackFormController::class, 'store']);
