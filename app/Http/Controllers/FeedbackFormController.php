<?php

namespace App\Http\Controllers;

use App\Classes\CheckRules;
use App\Classes\FeedbackForm;

class FeedbackFormController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $data = request()->all();
        $value = FeedbackForm::getInputs($data);

        $validated = request()->validate(CheckRules::getValidationRules($value));

        return response($validated,200)
                        ->header('Content-Type', 'text/plain');
    }
}
