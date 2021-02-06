<?php declare(strict_types=1);

namespace VitesseCms\Communication\Repositories;

use VitesseCms\Block\Repositories\BlockFormBuilderRepository;
use VitesseCms\Communication\Repositories\RepositoryInterface;
use VitesseCms\Content\Repositories\ItemRepository;
use VitesseCms\Core\Interfaces\RepositoryCollectionInterface;
use VitesseCms\Datagroup\Repositories\DatagroupRepository;
use VitesseCms\Database\Interfaces\BaseRepositoriesInterface;
use VitesseCms\Language\Repositories\LanguageRepository;

class RepositoryCollection implements RepositoryInterface, RepositoryCollectionInterface, BaseRepositoriesInterface
{
    /**
     * @var NewsletterTemplateRepository
     */
    public $newsletterTemplate;

    /**
     * @var BlockFormBuilderRepository
     */
    public $blockFormBuilder;

    /**
     * @var LanguageRepository
     */
    public $language;

    /**
     * @var DatagroupRepository
     */
    public $datagroup;

    /**
     * @var NewsletterRepository
     */
    public $newsletter;

    /**
     * @var NewsletterListRepository
     */
    public $newsletterList;

    /**
     * @var NewsletterQueueRepository
     */
    public $newsletterQueue;

    /**
     * @var EmailRepository
     */
    public $email;

    /**
     * @var ItemRepository
     */
    public $item;

    public function __construct(
        NewsletterTemplateRepository $newsletterTemplateRepository,
        BlockFormBuilderRepository $blockFormBuilderRepository,
        LanguageRepository $languageRepository,
        DatagroupRepository $datagroupRepository,
        NewsletterRepository $newsletterRepository,
        NewsletterListRepository $newsletterListRepository,
        NewsletterQueueRepository $newsletterQueueRepository,
        EmailRepository $emailRepository,
        ItemRepository $itemRepository
    ) {
        $this->newsletterTemplate = $newsletterTemplateRepository;
        $this->blockFormBuilder = $blockFormBuilderRepository;
        $this->language = $languageRepository;
        $this->datagroup = $datagroupRepository;
        $this->newsletter = $newsletterRepository;
        $this->newsletterList = $newsletterListRepository;
        $this->newsletterQueue = $newsletterQueueRepository;
        $this->email = $emailRepository;
        $this->item = $itemRepository;
    }
}
