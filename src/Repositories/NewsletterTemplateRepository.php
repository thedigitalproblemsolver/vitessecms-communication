<?php declare(strict_types=1);

namespace VitesseCms\Communication\Repositories;

use VitesseCms\Communication\Models\NewsletterTemplate;
use VitesseCms\Communication\Models\NewsletterTemplateIterator;
use VitesseCms\Database\Models\FindValueIterator;

class NewsletterTemplateRepository
{
    public function getById(string $id, bool $hideUnpublished = true): ?NewsletterTemplate
    {
        NewsletterTemplate::setFindPublished($hideUnpublished);

        /** @var NewsletterTemplate $newsletterTemplate */
        $newsletterTemplate = NewsletterTemplate::findById($id);
        if (is_object($newsletterTemplate)):
            return $newsletterTemplate;
        endif;

        return null;
    }

    public function findAll(?FindValueIterator $findValues = null, bool $hideUnpublished = true): NewsletterTemplateIterator
    {
        NewsletterTemplate::setFindPublished($hideUnpublished);
        NewsletterTemplate::addFindOrder('name');
        $this->parsefindValues($findValues);

        return new NewsletterTemplateIterator(NewsletterTemplate::findAll());
    }

    protected function parsefindValues(?FindValueIterator $findValues = null): void
    {
        if ($findValues !== null) :
            while ($findValues->valid()) :
                $findValue = $findValues->current();
                NewsletterTemplate::setFindValue(
                    $findValue->getKey(),
                    $findValue->getValue(),
                    $findValue->getType()
                );
                $findValues->next();
            endwhile;
        endif;
    }
}
