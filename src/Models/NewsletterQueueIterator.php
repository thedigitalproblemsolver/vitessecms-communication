<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Models;

use ArrayIterator;

class NewsletterQueueIterator extends ArrayIterator
{
    public function __construct(array $emails)
    {
        parent::__construct($emails);
    }

    public function current(): NewsletterQueue
    {
        return parent::current();
    }
}
