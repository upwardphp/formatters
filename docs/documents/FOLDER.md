# Folder Class

The `Folder` class is a collection handler designed to store and manage `Upward\Formatters\Document` instances or any class implementing the `Upward\Formatters\Contracts\Document`. It provides various methods to filter, validate, and iterate through the stored documents, while also allowing you to easily count and access them.

## Usage

You can use the `Folder` class to manage a collection of documents. It provides methods for adding documents, validating them, filtering valid and invalid documents, and more.

```php
$folder = new Folder();

// Add documents to the folder
$folder->push($document1);
$folder->push($document2);

// Get valid documents
$validFolder = $folder->valid();

// Get invalid documents
$invalidFolder = $folder->invalids();

// Count documents
echo count($folder); // Output: 2

// Iterate over documents
foreach ($folder as $document) {
    // Process each document
}
```

## Methods

### `with(array $documents): self`

Creates a new instance of `Folder` and initializes it with the provided array of documents.

```php
$folder = Folder::with([$document1, $document2]);
```

### `push(\Upward\Formatters\Contracts\Document | \Upward\Formatters\Document $document): self`

Adds a `Upward\Formatters\Document` or `Upward\Formatters\Contracts\Document` to the folder. It unwraps the document if needed and ensures it is in the correct form.

```php
$folder->push($document);
```

### `documents(): array`

Returns all documents stored in the folder as an array.

```php
$documents = $folder->documents();
```

### `each(Closure $callback): self`

Iterates over each document in the folder, applying the given callback. The callback receives the document and its index as parameters.

```php
use Upward\Formatters\Contracts\Document;

$folder->each(function(Document $document, string|int $key) {
    // Perform actions on each document
});
```

### `valid(): self`

Returns a new `Folder` instance containing only the valid documents. A document is considered valid if it passes the `validate()` method without throwing an exception.

```php
$validFolder = $folder->valid();
```

### `validate(): void`

Validates all documents in the folder. If any document fails validation, an exception may be thrown by the document's `validate()` method.

```php
$folder->validate();
```

### `invalids(): self`

Returns a new `Folder` instance containing only the invalid documents. Documents that throw an `InvalidDocumentException` are considered invalid.

```php
$invalidFolder = $folder->invalids();
```

### `count(): int`

Returns the number of documents in the folder.

```php
$documentCount = count($folder); // Uses Countable interface
```
