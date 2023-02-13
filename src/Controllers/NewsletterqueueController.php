<?php declare(strict_types=1);

namespace VitesseCms\Communication\Controllers;

use VitesseCms\Communication\Enums\NewsletterListEnum;
use VitesseCms\Communication\Enums\NewsletterQueueEnum;
use VitesseCms\Communication\Enums\TranslationEnum;
use VitesseCms\Communication\Repositories\NewsletterListRepository;
use VitesseCms\Communication\Repositories\NewsletterQueueRepository;
use VitesseCms\Core\AbstractControllerFrontend;

class NewsletterqueueController extends AbstractControllerFrontend
{
    private NewsletterQueueRepository $newsletterQueueRepository;
    private NewsletterListRepository $newsletterListRepository;

    public function onConstruct()
    {
        parent::onConstruct();

        $this->newsletterQueueRepository = $this->eventsManager->fire(NewsletterQueueEnum::GET_REPOSITORY->value, new stdClass());
        $this->newsletterListRepository = $this->eventsManager->fire(NewsletterListEnum::GET_REPOSITORY->value, new stdClass());
    }

    public function unsubscribeAction(string $newsletterQueueId): void
    {
        $newsletterQueue = $this->newsletterQueueRepository->getById($newsletterQueueId);
        if ($newsletterQueue !== null) :
            $newsletterList = $this->newsletterListRepository->getById($newsletterQueue->getNewsletterListId());
            if ($newsletterList !== null) :
                $newsletterList->unsubscribeMember($newsletterQueue->getEmail())->save();
                $this->flashService->setSucces(TranslationEnum::COMMUNICATION_LIST_UNSUBSCRIBE_SUCCESS->name);
            endif;
        endif;

        $this->redirect($this->url->getBaseUri());
    }

    public function openedAction(string $newsletterQueueId): void
    {
        $newsletterQueue = $this->newsletterQueueRepository->getById($newsletterQueueId);
        if ($newsletterQueue !== null && $newsletterQueue->getDateOpened() !== null) :
            $newsletterQueue->setDateOpened((new DateTime())->format('Y-m-d H:i:s'))->save();
        endif;

        $this->response->setHeader('Content-Type', 'image/png');
        echo file_get_contents($this->configService->getVendorNameDir() . 'communication/src/Resources/assets/images/1_1_transparent.png');

        $this->disableView();
    }
}
