<?php declare(strict_types=1);

namespace VitesseCms\Communication\Models;

use VitesseCms\Database\AbstractCollection;

class NewsletterTemplateIterator extends \ArrayIterator
{
    public function __construct(array $newsletterLists)
    {
        parent::__construct($newsletterLists);
    }

    public function current(): NewsletterTemplate
    {
        return parent::current();
    }
}
