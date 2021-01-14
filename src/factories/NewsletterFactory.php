<?php declare(strict_types=1);

namespace VitesseCms\Communication\Factories;

use VitesseCms\Communication\Models\Newsletter;
use VitesseCms\Communication\Models\NewsletterList;
use VitesseCms\Communication\Models\NewsletterTemplate;
use VitesseCms\Language\Models\Language;

class NewsletterFactory
{
    public static function create(
        string $name,
        Language $language,
        NewsletterList $newsletterList,
        NewsletterTemplate $newsletterTemplate,
        string $subject,
        string $body = '',
        bool $published = false
    ): Newsletter
    {
        return (new Newsletter())
            ->setName($name)
            ->setLanguage((string)$language->getId())
            ->setList((string)$newsletterList->getId())
            ->setTemplate((string)$newsletterTemplate->getId())
            ->setSubject($subject)
            ->setBody($body)
            ->setPublished($published);
    }
}
