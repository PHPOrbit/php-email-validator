<?php

namespace PHPOrbit\EmailValidator;

class Fetcher
{
    private const BLOCKLIST_PATH = __DIR__ . '/../data/blocklist.conf';
    private const ALLOWLIST_PATH = __DIR__ . '/../data/allowlist.conf';

    /**
     * Loads the blocklist from the .conf file
     *
     * @return array
     */
    public static function loadBlocklist(): array
    {
        return self::loadList(self::BLOCKLIST_PATH);
    }

    /**
     * Loads the allowlist from the .conf file
     *
     * @return array
     */
    public static function loadAllowlist(): array
    {
        return self::loadList(self::ALLOWLIST_PATH);
    }

    /**
     * Reads the .conf file and returns an array of lines
     *
     * @param string $filePath
     * @return array
     */
    private static function loadList(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("List file not found: {$filePath}");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return array_map('trim', $lines);
    }
}
