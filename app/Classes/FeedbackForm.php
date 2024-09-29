<?php

namespace App\Classes;

use http\Client\Request;

class FeedbackForm
{
    public static function getInputs (array $formFields): string
    {
        if (isset($formFields['profession']) && CheckRules::isStudent($formFields['profession'])) {
            return 'student';
        }

        if (isset($formFields['region']) && CheckRules::isCenter($formFields['region'])) {
            return 'center';
        }

        if (isset($formFields['product']) && CheckRules::isPromo($formFields['product'])) {
            return 'promo';
        }

        return 'all';
    }

}
