<?php

declare(strict_types=1);

namespace VitesseCms\Communication;

use Phalcon\Di\DiInterface;
use VitesseCms\Communication\Models\Email;
use VitesseCms\Communication\Repositories\EmailRepository;
use VitesseCms\Communication\Repositories\NewsletterListRepository;
use VitesseCms\Communication\Repositories\NewsletterQueueRepository;
use VitesseCms\Communication\Repositories\NewsletterRepository;
use VitesseCms\Communication\Repositories\NewsletterTemplateRepository;
use VitesseCms\Communication\Repositories\RepositoryCollection;
use VitesseCms\Content\Repositories\ItemRepository;
use VitesseCms\Core\AbstractModule;
use VitesseCms\Core\Interfaces\RepositoryCollectionInterface;
use VitesseCms\Datagroup\Repositories\DatagroupRepository;
use VitesseCms\Language\Repositories\LanguageRepository;

class Module extends AbstractModule
{
    public function registerServices(DiInterface $di, string $string = null)
    {
        parent::registerServices($di, 'Communication');
        $di->setShared('repositories', $this->getRepositories());
    }

    public function getRepositories(): ?RepositoryCollectionInterface
    {
        return new RepositoryCollection(
            new NewsletterTemplateRepository(),
            new LanguageRepository(),
            new DatagroupRepository(),
            new NewsletterRepository(),
            new NewsletterListRepository(),
            new NewsletterQueueRepository(),
            new EmailRepository(Email::class),
            new ItemRepository()
        );
    }
}
