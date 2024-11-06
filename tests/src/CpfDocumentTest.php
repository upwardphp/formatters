<?php

use Upward\Formatters\Document;
use Upward\Formatters\Documents\CpfDocument;
use Upward\Formatters\Exceptions\Documents\CpfSequenceException;
use Upward\Formatters\Exceptions\Documents\InvalidCpfException;

it('should be able a valid CPF document', function (): void {
    $document = new Document(new CpfDocument(value: '86730784075'));

    $document->validate();

    expect(value: true)->toBeTrue();
});

it('should not be able a valid CPF', function (): void {
    $document = new Document(new CpfDocument(value: '10420678998'));

    expect(value: fn () => $document->validate())->toThrow(InvalidCpfException::class);
});

it('should not be able a valid CPF sequences', function (string $sequence): void {
    $document = new Document(new CpfDocument(value: $sequence));

    expect(value: fn () => $document->validate())->toThrow(CpfSequenceException::class);
})->with([
    '11111111111',
    '22222222222',
    '33333333333',
]);
