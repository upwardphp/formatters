<?php

use Upward\Formatters\Mask;

it('should be able apply mask in CPF document pattern', function (): void {
    $mask = new Mask(input: '86730784075', output: '###.###.###-##');

    expect(value: $mask->format())
        ->toBe(expected: '867.307.840-75');
});

it('should be able anonymize CPF', function (): void {
    $mask = new Mask(input: '86730784075', output: '###.***.***-##');

    expect(value: $mask->format())
        ->toBe(expected: '867.***.***-75');
});

it('should be able apply mask in phone number pattern', function (): void {
    $mask = new Mask(input: '11999988776', output: '(##) #####-####');

    expect(value: $mask->format())
        ->toBe(expected: '(11) 99998-8776');
});

it('should be able obscure CPF using $ as string', function (): void {
    $mask = new Mask(input: '86730784075', output: '###.$$$.$$$-##');

    $mask->obscureUsing(text: '$');

    expect(value: $mask->format())
        ->toBe(expected: '867.$$$.$$$-75');
});

it('should be able obscure CPF using $ as closure', function (): void {
    $mask = new Mask(input: '86730784075', output: '###.$$$.$$$-##');

    $mask->obscureUsing(text: fn (): string => '$');

    expect(value: $mask->format())
        ->toBe(expected: '867.$$$.$$$-75');
});

it('should not be able obscure CPF using closure return different type of string', function (): void {
    $mask = new Mask(input: '86730784075', output: '###.$$$.$$$-##');

    expect(value: fn () => $mask->obscureUsing(text: fn (): stdClass => new stdClass()))
        ->toThrow(exception: InvalidArgumentException::class);
});
