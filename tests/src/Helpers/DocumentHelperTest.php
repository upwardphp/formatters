<?php

use Upward\Formatters\Documents\CnpjDocument;
use Upward\Formatters\Documents\CpfDocument;
use function Upward\Formatters\Helpers\Document\choose as document_choose;

it('should be able choose CPF Document', function (string $value): void {
    $document = document_choose($value);

    expect(value: $document?->document)
        ->toBeInstanceOf(class: CpfDocument::class);
})->with([
    '12345678901',
    '02345678901',
    '0145659878',
]);

it('should be able choose CNPJ Document', function (string $value): void {
    $document = document_choose($value);

    expect(value: $document?->document)
        ->toBeInstanceOf(class: CnpjDocument::class);
})->with([
    '27001167000123',
    '02669370000141',
    '2669370000141',
]);
