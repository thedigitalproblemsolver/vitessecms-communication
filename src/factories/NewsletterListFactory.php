<?php declare(strict_types=1);

namespace VitesseCms\Communication\Factories;

use VitesseCms\Communication\Models\NewsletterList;
use VitesseCms\Language\Models\Language;

class NewsletterListFactory
{
    public static function create(string $name, Language $language, bool $published = false): NewsletterList
    {
        return (new NewsletterList())
            ->setName($name)
            ->setLanguage((string)$language->getId())
            ->setPublished($published)
        ;
    }
}
