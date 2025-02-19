<?php

use Upward\Formatters\Contracts\Document;
use Upward\Formatters\Document as DocumentWrapper;
use Upward\Formatters\Documents\CnpjDocument;
use Upward\Formatters\Documents\CpfDocument;
use Upward\Formatters\Exceptions\Documents\InvalidDocumentException;
use Upward\Formatters\Folder;
use Upward\Formatters\Mask;
use function Upward\Formatters\Helpers\Document\choose as document_choose;

it('should be able make folder', function (): void {
    $documents = [
        new CpfDocument(value: '12345678901'),
        new CnpjDocument(value: '61779852000114'),
    ];

    expect(value: Folder::with($documents))
        ->toBeInstanceOf(class: Folder::class);
});

it('should not be able make folder', function (): void {
    $documents = [
        new CpfDocument(value: '12345678901'),
        new CnpjDocument(value: '61779852000114'),
        new Mask(input: '12345678901', output: '###.###.###-##'),
    ];

    expect(value: fn () => Folder::with($documents))
        ->toThrow(exception: TypeError::class);
});

it('should be able make folder with Document Wrapper', function (): void {
    CpfDocument::$validateUsing = null;
    CnpjDocument::$validateUsing = null;

    expect(value: Folder::with([
        new DocumentWrapper(new CpfDocument(value: '12345678901')),
        new DocumentWrapper(new CnpjDocument(value: '27001167000123')),
        new DocumentWrapper(new CpfDocument(value: '93993939939')),
    ]))->toBeInstanceOf(class: Folder::class);
});

it('should be able validate all and throws an exception', function (): void {
    $folder = Folder::with([
        new DocumentWrapper(new CpfDocument(value: '12345678901')),
        new DocumentWrapper(new CnpjDocument(value: '27001167000123')),
        new DocumentWrapper(new CpfDocument(value: '93993939939')),
    ]);

    expect(value: fn () => $folder->validate())
        ->toThrow(exception: InvalidDocumentException::class);
});

it('should be able run each document', function (): void {
    $folder = Folder::with([
        new DocumentWrapper(new CnpjDocument(value: '27001167000123')),
    ]);

    $folder->each(callback: static function ($document): void {
        expect(value: $document)->toBeInstanceOf(class: Document::class);
    });
});

it('should be able count folder documents', function (): void {
    $folder = Folder::with(documents: [
        new DocumentWrapper(new CnpjDocument(value: '27001167000123')),
    ]);

    expect(value: $folder->count())
        ->toBeOne()
        ->and(value: count($folder))
        ->toBeOne();
});

it('should be able count invalid documents', function (): void {
    $folder = Folder::with(documents: [
        new DocumentWrapper(new CnpjDocument(value: '27001167000123')),
        new DocumentWrapper(new CnpjDocument(value: '27001167000173')),
        new DocumentWrapper(new CnpjDocument(value: '2700116700012223')),
        new DocumentWrapper(new CnpjDocument(value: '27001167003')),
    ]);

    expect(value: $folder->invalids()->count())
        ->toBe(expected: 3);
});

it('should be able count empty invalid documents', function (): void {
    $folder = Folder::with(documents: [
        document_choose(value: '919.163.200-58'),
        document_choose(value: '277.198.500-41'),
    ]);

    expect(value: $folder->invalids()->count())
        ->toBe(expected: 0);
});

it('should be able iterate in folder', function (): void {
    $folder = Folder::with(documents: [
        new DocumentWrapper(new CpfDocument(value: '12345678901')),
        new DocumentWrapper(new CnpjDocument(value: '27001167000123')),
        new DocumentWrapper(new CpfDocument(value: '93993939939')),
    ]);

    foreach ($folder as $document) {
        expect(value: $document)->toBeInstanceOf(class: Document::class);
    }
});
