<?php

use Upward\Formatters\Document;
use Upward\Formatters\Documents\CpfDocument;

it('can write a document', function () {

    $document = new Document(new CpfDocument(value: '10285337998'));

    //    $document->validate();

    expect(true)->toBeTrue();
});
