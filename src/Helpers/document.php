<?php

namespace Upward\Formatters\Helpers\Document;

use Exception;
use Upward\Formatters\Document;
use Upward\Formatters\Documents\{CnpjDocument, CpfDocument};
use Upward\Formatters\Exceptions\Documents\InvalidDocumentException;
use function Upward\Formatters\Helpers\Sanitization\only_digits;

function choose(string $value): Document|null
{
    $value = only_digits($value);

    if (strlen(string: $value) < 11) {
        $value = str_pad(string: $value, length: 11, pad_string: '0', pad_type: STR_PAD_LEFT);
    }

    if (strlen(string: $value) > 11) {
        $value = str_pad(string: $value, length: 14, pad_string: '0', pad_type: STR_PAD_LEFT);
    }

    try {
        return new Document(
            document: match (strlen(string: $value)) {
                11 => new CpfDocument($value),
                14 => new CnpjDocument($value),
                default => InvalidDocumentException::class,
            }
        );
    } catch (Exception) {
        return null;
    }
}
