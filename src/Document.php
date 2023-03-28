<?php

declare(strict_types=1);

namespace DocumentSearch;

use Iterator;

interface Document
{
    public function getName(): string;
    public function getIterator(): Iterator;
}
