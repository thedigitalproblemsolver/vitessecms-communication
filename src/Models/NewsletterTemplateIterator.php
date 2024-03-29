<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Models;

use ArrayIterator;

class NewsletterTemplateIterator extends ArrayIterator
{
    public function __construct(array $emails)
    {
        parent::__construct($emails);
    }

    public function current(): NewsletterTemplate
    {
        return parent::current();
    }
}
