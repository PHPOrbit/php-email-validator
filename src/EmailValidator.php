<?php

namespace PHPOrbit\EmailValidator;

/**
 * Class EmailValidator
 *
 * The EmailValidator class provides methods to validate email addresses.
 * It checks the format of the email, determines if the email is from a disposable domain,
 * and verifies if the email domain has valid MX records.
 *
 * @package PHPOrbit\EmailValidator
 * @link https://phporbit.org
 * @link https://github.com/phporbit
 *
 * ### Usage Examples
 *
 * ```php
 * <?php
 *
 * require 'vendor/autoload.php';
 *
 * use PHPOrbit\EmailValidator\EmailValidator;
 * use PHPOrbit\EmailValidator\Fetcher;
 *
 * // Load blocklist and allowlist
 * $blocklist = Fetcher::loadBlocklist();
 * $allowlist = Fetcher::loadAllowlist();
 *
 * // Create an instance of EmailValidator
 * $validator = new EmailValidator($blocklist, $allowlist);
 *
 * // Validate email format
 * $email = "user@example.com";
 * if ($validator->isValidFormat($email)) {
 *     echo "The email format is valid.\n";
 * } else {
 *     echo "The email format is invalid.\n";
 * }
 *
 * // Check if email is disposable
 * if ($validator->isDisposable($email)) {
 *     echo "The email is disposable.\n";
 * } else {
 *     echo "The email is not disposable.\n";
 * }
 *
 * // Check if email has valid MX records
 * if ($validator->hasValidMX($email)) {
 *     echo "The email has valid MX records.\n";
 * } else {
 *     echo "The email does not have valid MX records.\n";
 * }
 *
 * ```
 */
class EmailValidator
{
    private array $blocklist;
    private array $allowlist;

    /**
     * EmailValidator constructor.
     *
     * @param array $blocklist List of disposable email domains to block.
     * @param array $allowlist List of email domains to allow.
     */
    public function __construct(array $blocklist, array $allowlist)
    {
        $this->blocklist = $blocklist;
        $this->allowlist = $allowlist;
    }

    /**
     * Validates the format of the given email address.
     *
     * @param string $email The email address to validate.
     * @return bool Returns true if the email format is valid, false otherwise.
     */
    public function isValidFormat(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Checks if the given email address is from a disposable email provider.
     *
     * @param string $email The email address to check.
     * @return bool Returns true if the email is disposable, false otherwise.
     */
    public function isDisposable(string $email): bool
    {
        $domain = strtolower(substr(strrchr($email, "@"), 1));

        if (in_array($domain, $this->allowlist)) {
            return false;
        }

        return in_array($domain, $this->blocklist);
    }

    /**
     * Checks if the given email address has valid MX records.
     *
     * @param string $email The email address to check.
     * @return bool Returns true if the email domain has valid MX records, false otherwise.
     */
    public function hasValidMX(string $email): bool
    {
        $domain = strtolower(substr(strrchr($email, "@"), 1));
        return checkdnsrr($domain, "MX");
    }
}