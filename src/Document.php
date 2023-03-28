<?php

declare(strict_types=1);

namespace App;

use Iterator;

interface Document
{
    public function getName(): string;
    public function getIterator(): Iterator;
}
