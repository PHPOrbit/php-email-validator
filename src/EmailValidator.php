<?php

namespace HarunGecit\EmailValidator;

class EmailValidator
{
    private array $blocklist;
    private array $allowlist;

    public function __construct(array $blocklist, array $allowlist)
    {
        $this->blocklist = $blocklist;
        $this->allowlist = $allowlist;
    }

    public function isValidFormat(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function isDisposable(string $email): bool
    {
        $domain = strtolower(substr(strrchr($email, "@"), 1));

        if (in_array($domain, $this->allowlist)) {
            return false;
        }

        return in_array($domain, $this->blocklist);
    }

    public function hasValidMX(string $email): bool
    {
        $domain = strtolower(substr(strrchr($email, "@"), 1));
        return checkdnsrr($domain, "MX");
    }
}
