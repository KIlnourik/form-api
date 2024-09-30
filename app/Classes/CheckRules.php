<?php

namespace App\Classes;

use Illuminate\Http\Request;
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
        'address' => ['string', 'email'],
        'profession' => ['nullable','string'],
        'region' => ['required', 'string'],
        'product' => ['required', 'string'],
    ];

    /**
     * @param string $profession
     * @return bool
     */
    public static function isStudent (string $profession): bool
    {
        return $profession === self::STUDENT_PROFESSION;
    }

    /**
     * @param string $product
     * @return bool
     */
    public static function isPromo (string $product): bool
    {
        return $product === self::PROMO_PRODUCT;
    }

    /**
     * @param string $product
     * @return bool
     */
    public static function isSpecial (string $product): bool
    {
        return $product === self::SPECIAL_PRODUCT;
    }

    /**
     * @param string $region
     * @return bool
     */
    public static function isCenter (string $region): bool
    {
        return in_array($region, self::CAPITALS);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public static function hasAddress (Request $request): bool
    {
        return $request->has('address');
    }

    /**
     * @param array $formFields
     * @return string
     */
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

    /**
     * @param $value
     * @return array|string[]
     */
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

    /**
     * @param string $value
     * @param Request $request
     * @return array
     */
    public static function getValidationRules (string $value, Request $request): array
    {
        $rules = array();

        $inputs = self::getValidatingInputs($value);
        foreach ($inputs as $input) {
            $rules = Arr::add($rules, $input, self::VALIDATING_RULES[$input]);
        }

        self::hasAddress($request)
            && $rules = Arr::add($rules, 'address', self::VALIDATING_RULES['address']);

        (self::isSpecial($request['product']) && !in_array('product', $inputs))
            && $rules = Arr::add($rules, 'product', self::VALIDATING_RULES['product']);

        return $rules;
    }
}
