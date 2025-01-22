<?php

require 'vendor/autoload.php';

use PHPOrbit\EmailValidator\EmailValidator;
use PHPOrbit\EmailValidator\Fetcher;

// Load blocklist and allowlist
$blocklist = Fetcher::loadBlocklist();
$allowlist = Fetcher::loadAllowlist();

// Create an instance of EmailValidator
$validator = new EmailValidator($blocklist, $allowlist);

// Validate email format
$email = "user@example.com";
if ($validator->isValidFormat($email)) {
    echo "The email format is valid.\n";
} else {
    echo "The email format is invalid.\n";
}

// Check if email is disposable
if ($validator->isDisposable($email)) {
    echo "The email is disposable.\n";
} else {
    echo "The email is not disposable.\n";
}

// Check if email has valid MX records
if ($validator->hasValidMX($email)) {
    echo "The email has valid MX records.\n";
} else {
    echo "The email does not have valid MX records.\n";
}