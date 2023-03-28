<?php

declare(strict_types=1);

namespace DocumentSearch;

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

        // $words = preg_split("/[^[:word:]+'{0,1}[:word:]]/", $content, -1, PREG_SPLIT_NO_EMPTY);
        $words = preg_split("/[\[\]\(\)\-\=\s,\.\"\'\:\;]/", $content, -1, PREG_SPLIT_NO_EMPTY);
        if ($words === false) return new EmptyIterator;

        return new ArrayIterator($words);
    }
}
