<?php declare(strict_types=1);

namespace VitesseCms\Communication\Factories;

use VitesseCms\Communication\Models\NewsletterTemplate;
use VitesseCms\Language\Models\Language;

class NewsletterTemplateFactory
{
    public static function create(
        string $name,
        Language $language,
        string $template,
        bool $published = false
    ): NewsletterTemplate {
        return (new NewsletterTemplate())
            ->setName($name)
            ->setLanguage((string)$language->getId())
            ->setTemplate($template)
            ->setPublished($published)
        ;
    }
}
