<?php declare(strict_types=1);

namespace VitesseCms\Communication\Repositories;

use VitesseCms\Communication\Models\NewsletterList;
use VitesseCms\Communication\Models\NewsletterListIterator;
use VitesseCms\Database\Interfaces\FindAllInterface;
use VitesseCms\Database\Models\FindValueIterator;

class NewsletterListRepository
{
    public function getById(string $id, bool $hideUnpublished = true): ?NewsletterList
    {
        NewsletterList::setFindPublished($hideUnpublished);

        /** @var NewsletterList $newsletterList */
        $newsletterList = NewsletterList::findById($id);
        if (is_object($newsletterList)):
            return $newsletterList;
        endif;

        return null;
    }

    public function findAll(?FindValueIterator $findValues = null, bool $hideUnpublished = true): NewsletterListIterator
    {
        NewsletterList::setFindPublished($hideUnpublished);
        NewsletterList::addFindOrder('name');
        $this->parsefindValues($findValues);

        return new NewsletterListIterator(NewsletterList::findAll());
    }

    protected function parsefindValues(?FindValueIterator $findValues = null): void
    {
        if ($findValues !== null) :
            while ($findValues->valid()) :
                $findValue = $findValues->current();
                NewsletterList::setFindValue(
                    $findValue->getKey(),
                    $findValue->getValue(),
                    $findValue->getType()
                );
                $findValues->next();
            endwhile;
        endif;
    }
}
