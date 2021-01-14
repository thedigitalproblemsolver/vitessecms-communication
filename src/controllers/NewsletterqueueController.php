<?php declare(strict_types=1);

namespace VitesseCms\Communication\Controllers;

use VitesseCms\Communication\Helpers\NewsletterQueueHelper;
use VitesseCms\Communication\Repositories\RepositoriesInterface;
use VitesseCms\Core\AbstractController;

class NewsletterqueueController extends AbstractController implements RepositoriesInterface
{
    public function unsubscribeAction(string $newsletterQueueId): void
    {
        $newsletterQueue = $this->repositories->newsletterQueue->getById($newsletterQueueId);
        if($newsletterQueue !== null) :
            $newsletterList = $this->repositories->newsletterList->getById($newsletterQueue->getNewsletterListId());
            if($newsletterList !== null) :
                $newsletterList->unsubscribeMember($newsletterQueue->getEmail())->save();
                $this->flash->setSucces('NEWSLETTER_LIST_UNSUBSCRIBE_SUCCESS');
            endif;
        endif;

        $this->redirect($this->url->getBaseUri());
    }

    public function openedAction(string $newsletterQueueId): void
    {
        $newsletterQueue = $this->repositories->newsletterQueue->getById($newsletterQueueId);
        if ($newsletterQueue !== null && $newsletterQueue->getDateOpened() !== null) :
                $newsletterQueue->setDateOpened((new DateTime())->format('Y-m-d H:i:s'))->save();
        endif;

        $this->response->setHeader('Content-Type', 'image/png');
        echo file_get_contents($this->configuration->getVendorNameDir().'communication/src/resources/assets/images/1_1_transparent.png');

        $this->disableView();
    }
}
