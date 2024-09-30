<?php

namespace App\Http\Controllers;

use App\Classes\CheckRules;
use App\Classes\FeedbackForm;
use App\Mail\FormReceived;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
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
        $value = CheckRules::getInputs($data);

        $validator = validator($data, CheckRules::getValidationRules($value, request()));

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $validated = $validator->validate();


        CheckRules::hasAddress(request())
            ? Mail::to($validated['address'])->send(
                new FormReceived(Arr::except($validated, 'address')))
            : Mail::to($value . '@example.com')->send(
                  new FormReceived($validated));

        return CheckRules::hasAddress(request())
            ? response(Arr::except($validated, 'address'),200)
                        ->header('Content-Type', 'text/plain')
            : response($validated,200)
                        ->header('Content-Type', 'text/plain');
    }
}
