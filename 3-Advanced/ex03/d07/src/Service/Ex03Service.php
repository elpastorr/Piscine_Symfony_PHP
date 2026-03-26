<?php

namespace App\Service;

class Ex03Service
{
    public function uppercaseWords(string $text): string
    {
        return ucwords($text);
    }

    public function countNumbers(string $text): int
    {
        preg_match_all('/\d/', $text, $matches);
        return count($matches[0]);
    }
}