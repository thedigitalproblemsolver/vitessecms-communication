<?php declare(strict_types=1);

namespace VitesseCms\Communication\Models;

use VitesseCms\Database\AbstractCollection;

class NewsletterTemplate extends AbstractCollection
{
    /**
     * @var string
     */
    public $template;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $language;

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(string $template): NewsletterTemplate
    {
        $this->template = $template;
        return $this;
    }

    public function setName(string $name): NewsletterTemplate
    {
        $this->name = $name;
        return $this;
    }

    public function setLanguage(string $language): NewsletterTemplate
    {
        $this->language = $language;
        return $this;
    }
}
