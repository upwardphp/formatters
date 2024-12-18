<?php

namespace Upward\Formatters\Helpers\Sanitization;

function only_digits(string $value): string
{
    return preg_replace(
        pattern: '/[^0-9]/is',
        replacement: '',
        subject: $value,
    );
}
