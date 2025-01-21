<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPOrbit\EmailValidator\EmailValidator;
use PHPOrbit\EmailValidator\Fetcher;

class EmailValidatorTest extends TestCase
{
    private EmailValidator $validator;

    /**
     * Sets up the validator instance before each test.
     */
    protected function setUp(): void
    {
        $blocklist = Fetcher::loadBlocklist();
        $allowlist = Fetcher::loadAllowlist();

        $this->validator = new EmailValidator($blocklist, $allowlist);
    }

    /**
     * Tests if the email format validation works correctly.
     */
    public function testValidFormat()
    {
        $this->assertTrue($this->validator->isValidFormat("user@example.com"), "The email format should be valid.");
        $this->assertFalse($this->validator->isValidFormat("invalid-email"), "The email format should be invalid.");
    }

    /**
     * Tests if disposable email detection works correctly.
     */
    public function testDisposableEmail()
    {
        $this->assertFalse($this->validator->isDisposable("user@example.com"), "user@example.com should not be disposable.");
        $this->assertTrue($this->validator->isDisposable("temporary@disposable.com"), "temporary@disposable.com should be disposable.");
    }

    /**
     * Tests if the MX record validation works correctly.
     */
    public function testValidMXRecord()
    {
        $this->assertTrue($this->validator->hasValidMX("user@example.com"), "The email address should have a valid MX record.");
        $this->assertFalse($this->validator->hasValidMX("invalid-domain@invalid.com"), "There should be no MX record for an invalid domain.");
    }
}
