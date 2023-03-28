<?php

declare(strict_types=1);

namespace App;

use DirectoryIterator;

class DocumentCollection implements Collection
{
    private DirectoryIterator $data;

    public function __construct(string $srcDir = 'data')
    {
        $this->data = new DirectoryIterator($srcDir);
    }
    // Called for each iteration.
    public function current(): mixed
    {
        return new File($this->data->current()->getPathName());
    }

    // Called for each iteration.
    public function key(): mixed
    {
    }

    // Called after each iteration. Moves the internal pointer forward.
    public function next(): void
    {
        $this->data->next();
    }

    // Called before iteration.
    public function rewind(): void
    {
        $this->data->rewind();
    }

    // Called for each iteration. Iteration stops if this returns false.
    public function valid(): bool
    {
        return $this->data->valid();
    }
}
