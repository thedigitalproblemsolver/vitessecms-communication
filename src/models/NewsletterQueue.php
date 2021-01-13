<?php declare(strict_types=1);

namespace VitesseCms\Communication\Models;

use VitesseCms\Database\AbstractCollection;

class NewsletterQueue extends AbstractCollection
{
    /**
     * @var string
     */
    public $body;

    public function getBodyField(): string
    {
        return $this->_('body');
    }
}
