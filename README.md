# harungecit/php-email-validator

A PHP library for robust email validation. This package checks the email format, detects disposable email domains, and validates MX records to ensure the reliability of email addresses.

---

## Features
- **Format Validation:** Ensures the email address follows a valid syntax.
- **Disposable Email Detection:** Identifies temporary or disposable email addresses using an up-to-date blocklist.
- **MX Record Validation:** Verifies the existence of a mail server for the domain.
- **Lightweight:** Includes all dependencies and blocklists in the package for offline use.

---

## Installation

Install the package via Composer:

```bash
composer require harungecit/php-email-validator
```

---

## Compatibility

This package is compatible with the following PHP versions:

- PHP 7.4
- PHP 8.0
- PHP 8.1
- PHP 8.2
- PHP 8.3
- PHP 8.4

For other PHP versions, please ensure your project meets the minimum requirements of PHP 7.4 or later.

---

## Usage

### Basic Example

```php
use HarunGecit\EmailValidator\EmailValidator;
use HarunGecit\EmailValidator\Fetcher;

// Load blocklist and allowlist from the package
$blocklist = Fetcher::loadBlocklist();
$allowlist = Fetcher::loadAllowlist();

// Initialize the validator
$validator = new EmailValidator($blocklist, $allowlist);

$email = "example@10minutemail.com";

// Perform validations
if (!$validator->isValidFormat($email)) {
    echo "Invalid email format.";
} elseif ($validator->isDisposable($email)) {
    echo "Disposable email detected.";
} elseif (!$validator->hasValidMX($email)) {
    echo "Invalid MX record.";
} else {
    echo "Email is valid.";
}
```

---

### Advanced Example with Form Validation

Integrate the validator into a user registration form:

```php
use HarunGecit\EmailValidator\EmailValidator;
use HarunGecit\EmailValidator\Fetcher;

$blocklist = Fetcher::loadBlocklist();
$allowlist = Fetcher::loadAllowlist();
$validator = new EmailValidator($blocklist, $allowlist);

$email = $_POST['email'] ?? '';

if (!$validator->isValidFormat($email)) {
    die("Error: Invalid email format.");
}

if ($validator->isDisposable($email)) {
    die("Error: Disposable email addresses are not allowed.");
}

if (!$validator->hasValidMX($email)) {
    die("Error: Email domain does not have a valid MX record.");
}

echo "Success: Email is valid and ready for registration.";
```

---

## How It Works

1. **Email Format Validation:**
   - The package uses PHP's `filter_var` function to validate the basic format of the email address.
   - Example: `test@example.com` is valid, but `test@com` is not.

2. **Disposable Email Detection:**
   - The package checks the domain of the email address against a blocklist of disposable email providers.
   - Example: `user@mailinator.com` is marked as disposable.

3. **MX Record Validation:**
   - The package uses the `checkdnsrr` function to verify if the email domain has a valid mail exchange (MX) record.
   - Example: `example.com` with a valid mail server passes validation.

---

## Blocklist and Allowlist

The package comes with preloaded blocklist and allowlist files located in the `data/` directory. These lists are updated regularly to ensure accuracy. 

- **Blocklist (`blocklist.json`):** Contains domains of known disposable email providers.
- **Allowlist (`allowlist.json`):** Contains domains that should always be considered valid, even if they resemble disposable domains.

You can customize these files as needed.

---

## Testing

The package includes PHPUnit tests to verify its functionality. Run the tests using the following command:

```bash
vendor/bin/phpunit tests
```

---

## Contributing

Contributions are welcome! To contribute:
1. Fork the repository.
2. Make your changes.
3. Submit a pull request.

Please ensure that all new code is covered by tests and adheres to the PSR-12 coding standards.

---

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.

---

## Author

- **Harun Geçit**  
  [GitHub](https://github.com/harungecit) | [LinkedIn](https://linkedin.com/in/harungecit) | [Email](mailto:info@harungecit.com)

---

## Changelog

### v1.0.0
- Initial release with support for:
  - Email format validation
  - Disposable email detection
  - MX record validation