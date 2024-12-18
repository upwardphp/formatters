<?php

namespace Upward\Formatters\Attributes;

use Attribute;
use Upward\Formatters\Contracts\SanitizationAttribute;
use function Upward\Formatters\Helpers\Sanitization\only_digits;

#[Attribute(Attribute::TARGET_PROPERTY)]
class OnlyDigits implements SanitizationAttribute
{
    public static function resolve(string $value): string
    {
        return only_digits($value);
    }
}
