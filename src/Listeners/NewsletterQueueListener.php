<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners;

use VitesseCms\Communication\Repositories\NewsletterQueueRepository;

class NewsletterQueueListener
{
    public function __construct(private NewsletterQueueRepository $newsletterQueueRepository){}

    public function getRepository(): NewsletterQueueRepository
    {
        return $this->newsletterQueueRepository;
    }
}