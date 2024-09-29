<?php

namespace App\Classes;

use Illuminate\Support\Arr;

class CheckRules
{
    const STUDENT_PROFESSION = 'студент';
    const PROMO_PRODUCT  = 'promo';
    const CAPITALS = ['Москва', 'Санкт-Петербург'];
    const SPECIAL_PRODUCT = 'special';

    const VALIDATING_RULES = [
        'name' => ['required', 'string', 'min:3', 'max:255'],
        'email' => ['required', 'email'],
        'phone' => ['required', 'string'],
        'address' => ['string'],
        'profession' => ['string'],
        'region' => ['required', 'string'],
        'product' => ['required', 'string'],
    ];

    public static function isStudent (string $profession): bool
    {
        return $profession === self::STUDENT_PROFESSION;
    }

    public static function isPromo (string $product): bool
    {
        return $product === self::PROMO_PRODUCT;
    }

    public static function isSpecial (string $product): bool
    {
        return $product === self::SPECIAL_PRODUCT;
    }

    public static function isCenter (string $region): bool
    {
        return in_array($region, self::CAPITALS);
    }

    public static function getValidatingInputs ($value): array
    {
        $map = [
            'student' => ['name', 'email', 'phone', 'profession', 'region', 'product'],
            'center' => ['name', 'email', 'phone', 'profession', 'region', 'product'],
            'promo' => ['name', 'email', 'phone', 'product'],
            'all' => ['name', 'email', 'phone', 'region', 'profession'],
        ];

        return $map[$value] ?? [];
    }

    public static function getValidationRules ($value): array
    {
        $rules = array();

        foreach (self::getValidatingInputs($value) as $input) {
            $rules = Arr::add($rules, $input, self::VALIDATING_RULES[$input]);
        }

        return $rules;
    }
}
