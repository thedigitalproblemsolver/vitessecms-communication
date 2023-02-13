<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners;

use VitesseCms\Communication\Repositories\NewsletterListRepository;

class NewsletterListListener
{
    public function __construct(private NewsletterListRepository $newsletterListRepository){}

    public function getRepository(): NewsletterListRepository
    {
        return $this->newsletterListRepository;
    }
}