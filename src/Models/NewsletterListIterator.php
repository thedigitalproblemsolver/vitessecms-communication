<?php
declare(strict_types=1);

namespace VitesseCms\Communication\Models;

use ArrayIterator;
use VitesseCms\Core\Interfaces\ArrayIteratorInterface;

class NewsletterListIterator extends ArrayIterator
{
    public function __construct(array $newsletterQueue)
    {
        parent::__construct($newsletterQueue);
    }

    public function current(): NewsletterList
    {
        return parent::current();
    }
}
