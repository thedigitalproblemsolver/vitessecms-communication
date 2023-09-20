<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Repositories;

use VitesseCms\Communication\Models\NewsletterQueue;
use VitesseCms\Communication\Models\NewsletterQueueIterator;
use VitesseCms\Database\Models\FindValueIterator;

class NewsletterQueueRepository
{
    public function getById(string $id, bool $hideUnpublished = true): ?NewsletterQueue
    {
        NewsletterQueue::setFindPublished($hideUnpublished);

        /** @var NewsletterQueue $newsletterQueue */
        $newsletterQueue = NewsletterQueue::findById($id);
        if (is_object($newsletterQueue)):
            return $newsletterQueue;
        endif;

        return null;
    }

    public function findAll(
        ?FindValueIterator $findValues = null,
        bool $hideUnpublished = true
    ): NewsletterQueueIterator {
        NewsletterQueue::setFindPublished($hideUnpublished);
        NewsletterQueue::addFindOrder('name');
        $this->parseFindValues($findValues);

        return new NewsletterQueueIterator(NewsletterQueue::findAll());
    }

    protected function parseFindValues(?FindValueIterator $findValues = null): void
    {
        if ($findValues !== null) :
            while ($findValues->valid()) :
                $findValue = $findValues->current();
                NewsletterQueue::setFindValue(
                    $findValue->getKey(),
                    $findValue->getValue(),
                    $findValue->getType()
                );
                $findValues->next();
            endwhile;
        endif;
    }
}
