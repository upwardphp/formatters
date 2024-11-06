<?php

use Upward\Formatters\Document;
use Upward\Formatters\Documents\CpfDocument;

it('should be able a valid CPF document', function (): void {
    $document = new Document(new CpfDocument(value: '86730784075'));

    $document->validate();

    expect(value: true)->toBeTrue();
});

it('should be able a invalid CPF', function (string $value): void {
    $document = new Document(new CpfDocument(value: '86730784075'));

    $document->validate();

    expect(value: true)->toBeTrue();
})->with([
    '11111111111',
    '10220456778',
]);
