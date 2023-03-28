<?php

declare(strict_types=1);

namespace DocumentSearch;

class Registry
{
    private static $instance;
    private $data = [];


    // A singleton is probably a good idea.
    private function __construct() {}
    public static function getInstance(): static
    {
        if (! static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function register(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function get(string $key): mixed
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
    }
}
