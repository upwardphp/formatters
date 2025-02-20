<?php

use Upward\Formatters\Document;
use Upward\Formatters\Documents\CpfDocument;
use Upward\Formatters\Exceptions\Documents\CpfSequenceException;
use Upward\Formatters\Exceptions\Documents\InvalidCpfException;
use Upward\Formatters\Mask;

describe(description: 'Validation', tests: function (): void {
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

    it('should be able modify validation', function (): void {
        $cpf = new CpfDocument(value: '86730784075');

        $cpf->modifyValidateUsing(
            callback: static function (CpfDocument $document): void {
                throw new DomainException();
            }
        );

        $document = new Document($cpf);

        expect(value: fn () => $document->validate())->toThrow(DomainException::class);
    });
});

describe(description: 'Value', tests: function (): void {
    it('should be only digits', function (): void {
        $document = new Document(new CpfDocument(value: '86730784075   a'));

        expect(value: $document->value())
            ->toBe(expected: '86730784075');
    });
});

describe(description: 'Format', tests: function (): void {
    it('should be able format CPF', function (): void {
        $document = new Document(new CpfDocument(value: '86730784075'));

        expect(value: $document->format())
            ->toBe(expected: '867.307.840-75');
    });

    it('should be able anonymize CPF document', function (): void {
        $document = new Document(new CpfDocument(value: '86730784075'));

        expect(value: $document->anonymize())
            ->toBe('867.***.***-75');
    });

    it('should be able modify anonymization', function (): void {
        $cpf = new CpfDocument(value: '86730784075');

        $cpf->modifyMaskUsing(callback: static function (CpfDocument $document): string {
            return (new Mask(input: $document->value(), output: '***.###.###-**'))->format();
        });

        $document = new Document($cpf);

        expect(value: $document->anonymize())
            ->toBe('***.307.840-**');
    });

    it('should not be able to format CPF with invalid digits', function (): void {
        $document = new Document(new CpfDocument(value: '0867307840750'));

        expect(value: $document->format())
            ->not
            ->toBe(expected: '867.307.840-75');
    });

});
