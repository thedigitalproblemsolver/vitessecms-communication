<?php declare(strict_types=1);

namespace VitesseCms\Communication\Repositories;

use VitesseCms\Block\Repositories\BlockFormBuilderRepository;
use VitesseCms\Communication\Repositories\EmailRepository;
use VitesseCms\Communication\Repositories\NewsletterListRepository;
use VitesseCms\Communication\Repositories\NewsletterQueueRepository;
use VitesseCms\Communication\Repositories\NewsletterRepository;
use VitesseCms\Communication\Repositories\NewsletterTemplateRepository;
use VitesseCms\Content\Repositories\ItemRepository;
use VitesseCms\Datagroup\Repositories\DatagroupRepository;
use VitesseCms\Language\Repositories\LanguageRepository;

/**
 * Interface RepositoryInterface
 * @property NewsletterTemplateRepository $newsletterTemplate
 * @property BlockFormBuilderRepository $blockFormBuilder
 * @property LanguageRepository $language
 * @property DatagroupRepository $datagroup
 * @property NewsletterRepository $newsletter
 * @property NewsletterListRepository $newsletterList
 * @property NewsletterQueueRepository $newsletterQueue
 * @property EmailRepository $email
 * @property ItemRepository $item
 */
interface RepositoryInterface
{
}
