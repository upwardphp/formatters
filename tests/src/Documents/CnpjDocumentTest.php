<?php

use Upward\Formatters\Document;
use Upward\Formatters\Documents\CnpjDocument;
use Upward\Formatters\Exceptions\Documents\CnpjSequenceException;
use Upward\Formatters\Exceptions\Documents\InvalidCnpjException;

describe(description: 'Validation', tests: function (): void {
    it('should be able a valid document', function (): void {
        $document = new Document(new CnpjDocument(value: '61779852000113'));

        $document->validate();

        expect(value: true)->toBeTrue();
    });

    it('should not be able a valid CNPJ', function (): void {
        $document = new Document(new CnpjDocument(value: '61779852000114'));

        expect(value: fn () => $document->validate())->toThrow(InvalidCnpjException::class);
    });

    it('should not be able a valid CNPJ sequences', function (string $sequence): void {
        $document = new Document(new CnpjDocument(value: $sequence));

        expect(value: fn () => $document->validate())->toThrow(CnpjSequenceException::class);
    })->with([
        '11111111111111',
        '22222222222222',
        '33333333333333',
    ]);

    it('should be able modify validation', function (): void {
        $cnpj = new CnpjDocument(value: '61779852000113');

        $cnpj->modifyValidateUsing(
            callback: static function (CnpjDocument $document): void {
                throw new DomainException();
            }
        );

        $document = new Document($cnpj);

        expect(value: fn () => $document->validate())->toThrow(DomainException::class);
    });
});
