<?php

declare(strict_types=1);

namespace App;

use ArrayIterator;
use EmptyIterator;
use Iterator;
use Throwable;

class File implements Document
{
    public function __construct(private string $name) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getIterator(): Iterator
    {
        try {
            $content = file_get_contents($this->name);
        } catch (Throwable $t) {
            return new EmptyIterator;
        }

        return new ArrayIterator(explode(' ', $content));
    }
}
