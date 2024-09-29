<?php

namespace App\Http\Controllers;

use App\Classes\CheckRules;
use App\Classes\FeedbackForm;
use App\Mail\FormReceived;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FeedbackFormController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     */
    public function store(): Response
    {
        $data = request()->all();
        $value = FeedbackForm::getInputs($data);

        $validator = Validator::make($data, CheckRules::getValidationRules($value));

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $validated = $validator->validate();

        Mail::to($value . '@example.com')->send(
            new FormReceived($validated)
        );

        return response($validated,200)
                        ->header('Content-Type', 'text/plain');
    }
}
