<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Models;

use ArrayIterator;

final class EmailIterator extends ArrayIterator
{
    public function __construct(array $emails)
    {
        parent::__construct($emails);
    }

    public function current(): Email
    {
        return parent::current();
    }
}
