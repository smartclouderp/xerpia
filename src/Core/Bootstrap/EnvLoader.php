<?php
namespace Xerpia\Core\Bootstrap;

class EnvLoader {
    public static function load(string $baseDir): void {
        if (file_exists($baseDir . '/.env')) {
            $dotenv = \Dotenv\Dotenv::createImmutable($baseDir);
            $dotenv->load();
        }
    }
}
