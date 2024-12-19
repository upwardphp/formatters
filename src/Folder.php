<?php

namespace Upward\Formatters;

use ArrayIterator;
use Closure;
use Countable;
use IteratorAggregate;
use Traversable;
use Upward\Formatters\Contracts\Document as DocumentInterface;
use Upward\Formatters\Exceptions\Documents\InvalidDocumentException;

class Folder implements Countable, IteratorAggregate
{
    /**
     * @var DocumentInterface[]
     */
    protected array $documents;

    public static function with(array $documents): self
    {
        $folder = new static();

        foreach ($documents as $document) {
            $folder->push($document);
        }

        return $folder;
    }

    /**
     * Push Document instance to Folder
     *
     * @param DocumentInterface|Document $document
     * @return $this
     */
    public function push(DocumentInterface|Document $document): self
    {
        $this->documents[] = $this->unwrap($document);

        return $this;
    }

    /**
     * Unwraps a Document to extract the Document interface.
     *
     * If the input is an instance of Document, it directly accesses the
     * `document` property. If the input is already a DocumentInterface, it wraps it in
     * a Document concrete to resolve attributes (annotations) and then accesses
     * the `document` property.
     *
     * This ensures that any required attributes are properly processed
     * before returning the Document instance.
     *
     * @param DocumentInterface|Document $document
     * @return DocumentInterface
     */
    protected function unwrap(DocumentInterface|Document $document): DocumentInterface
    {
        return $document instanceof Document
            ? $document->document
            : (new Document($document))->document; // Should execute Attributes
    }

    public function documents(): array
    {
        return $this->documents;
    }

    /**
     * Iterates over each document in the collection and applies the given callback.
     *
     * The callback receives the document and its key/index as parameters. This method
     * is chainable and returns the current instance after execution.
     *
     * @param Closure $callback
     * @return $this
     */
    public function each(Closure $callback): self
    {
        foreach ($this->documents as $key => $document) {
            $callback($document, $key);
        }

        return $this;
    }

    /**
     * Filters the current documents to include only valid ones.
     *
     * This method iterates through all documents in the current Folder, validates
     * each document using its `validate()` method, and collects only the valid
     * documents into a new `Folder` instance. If a document is invalid, it is
     * ignored (caught by the `InvalidDocumentException`).
     *
     * @return $this
     */
    public function valid(): self
    {
        $folder = new static();

        foreach ($this->documents as $document) {
            try {
                $document->validate();

                $folder->push($document);
            } catch (InvalidDocumentException) {
                //
            }
        }

        return $folder;
    }

    /**
     * Validates all documents within the folder.
     *
     * This method iterates through each document in the Folder and calls its
     * `validate()` method. If any document fails validation, an exception
     * may be thrown by the document's `validate()` implementation.
     *
     * @return void
     * @throws InvalidDocumentException
     */
    public function validate(): void
    {
        foreach ($this->documents as $document) {
            $document->validate();
        }
    }

    /**
     * Filters the current documents to include only invalid ones.
     *
     * This method iterates through all documents in the current folder, attempting
     * to validate each document. If a document fails validation (throws an
     * `InvalidDocumentException`), it is added to a new `Folder` instance. Valid
     * documents are ignored.
     *
     * @return $this
     */
    public function invalids(): self
    {
        $folder = new static();

        foreach ($this->documents as $document) {
            try {
                $document->validate();
            } catch (InvalidDocumentException) {
                $folder->push($document);
            }
        }

        return $folder;
    }

    /**
     * Returns the number of documents in the folder.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->documents);
    }

    /**
     * Returns an iterator for the documents in the folder.
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator(array: $this->documents);
    }
}
