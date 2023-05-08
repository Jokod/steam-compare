<?php

namespace App\Service;

class Version
{
    public static function getVersion(): string
    {
        $hash = shell_exec('git rev-parse --verify --short HEAD');
        $tag  = shell_exec('git describe --exact-match ' . $hash);

        return trim($tag) ?: '';
    }
}
