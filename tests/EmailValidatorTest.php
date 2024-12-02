<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use HarunGecit\EmailValidator\EmailValidator;
use HarunGecit\EmailValidator\Fetcher;

class EmailValidatorTest extends TestCase
{
    private $validator;

    protected function setUp(): void
    {
        $blocklist = Fetcher::loadBlocklist();
        $allowlist = Fetcher::loadAllowlist();

        $this->validator = new EmailValidator($blocklist, $allowlist);
    }

    public function testValidFormat()
    {
        $this->assertTrue($this->validator->isValidFormat("user@example.com"), "Email formatı geçerli olmalı.");
        $this->assertFalse($this->validator->isValidFormat("invalid-email"), "Email formatı geçersiz olmalı.");
    }

    public function testDisposableEmail()
    {
        $this->assertFalse($this->validator->isDisposable("user@example.com"), "user@example.com disposable olmamalı.");
        $this->assertTrue($this->validator->isDisposable("temporary@disposable.com"), "temporary@disposable.com disposable olmalı.");
    }

    public function testValidMXRecord()
    {
        $this->assertTrue($this->validator->hasValidMX("user@example.com"), "Email adresinin geçerli bir MX kaydı olmalı.");
        $this->assertFalse($this->validator->hasValidMX("invalid-domain@invalid.com"), "Geçersiz bir domain için MX kaydı olmamalı.");
    }
}
