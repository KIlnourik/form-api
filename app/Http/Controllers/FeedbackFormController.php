<?php

namespace App\Http\Controllers;

use App\Classes\CheckRules;
use App\Classes\MailAddresses;
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

        $mailAddresses = MailAddresses::getMailAddresses(
            request(),
            $value,
            CheckRules::isSpecial(request()->get('product')),
            CheckRules::hasAddress(request()),
        );

        CheckRules::hasAddress(request()) && $validated = Arr::except($validated, 'address');

        Mail::to($mailAddresses)->send(new FormReceived($validated));

        return  response('Your form has successfully received!',200)
                        ->header('Content-Type', 'text/plain');
    }
}
