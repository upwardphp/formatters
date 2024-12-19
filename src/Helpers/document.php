<?php

namespace Upward\Formatters\Helpers\Document;

use Throwable;
use Upward\Formatters\Document;
use Upward\Formatters\Documents\{CnpjDocument, CpfDocument};
use Upward\Formatters\Exceptions\Documents\InvalidDocumentException;
use function Upward\Formatters\Helpers\Sanitization\only_digits;

function choose(string $value): Document|null
{
    $value = only_digits($value);

    if (!$value) {
        return null;
    }

    try {
        return new Document(
            document: match (strlen(string: $value)) {
                11 => new CpfDocument($value),
                14 => new CnpjDocument($value),
                default => InvalidDocumentException::class,
            }
        );
    } catch (Throwable) {
        return null;
    }
}
