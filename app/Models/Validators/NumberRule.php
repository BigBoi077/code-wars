<?php namespace Models\Validators;

use Zephyrus\Application\Rule;

class NumberRule
{
    public static function isInteger($number): Rule
    {
        return new Rule(function($data) {
            return !is_int($data);
        }, $number);
    }
}
