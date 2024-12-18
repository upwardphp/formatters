### Document Class

The `Document` class is a wrapper for any class implementing the `DocumentInterface`, providing a simple and consistent way to interact with different document types, such as CPF or CNPJ. It offers methods for validating, formatting, and anonymizing documents without exposing the underlying logic.

### Features:
- **Validation**: Validates the document using the `validate()` method.
- **Formatting**: Formats the document according to the specific type using the `format()` method.
- **Anonymization**: Anonymizes the document value for privacy with the `anonymize()` method.
- **Wrapper Pattern**: Encapsulates a `DocumentInterface` instance and provides a uniform interface for interacting with different document types.

#### Example Usage:
```php
$document = new Document($cnpj);
$document->validate();  // Validates the document
$document->format();    // Formats the document
$document->anonymize(); // Anonymizes the document
```

This class simplifies handling different document types by abstracting the validation, formatting, and anonymization logic, making it easier to work with various document classes interchangeably.

---

### Custom Document Example

To create a custom document, you need to implement the `Document` interface and define the required methods: `value()`, `validate()`, `format()`, and `anonymize()`.

#### Custom Document Class

```php
namespace Upward\Formatters\Documents;

use Upward\Formatters\Contracts\Document;
use Upward\Formatters\Exceptions\Documents\InvalidDocumentException;

class CustomDocument implements Document
{
    public function __construct(
        private string $value,
    )
    {
    }

    public function value(): string
    {
        return $this->value;
    }

    public function validate(): void
    {
        // Validation logic
    }

    public function format(): string
    {
        // Formatting logic
    }

    public function anonymize(): string
    {
        // Anonymization logic
    }
}
```

#### Using the Custom Document with the Wrapper

```php
use Upward\Formatters\Documents\CustomDocument;
use Upward\Formatters\Document;

$customDoc = new CustomDocument('1234567890');
$document = new Document($customDoc);

$document->validate();  // Validates the document
echo $document->format();  // Formats the document
echo $document->anonymize();  // Anonymizes the document
```
