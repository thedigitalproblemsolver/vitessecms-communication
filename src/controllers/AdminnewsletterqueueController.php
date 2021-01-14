<?php declare(strict_types=1);

namespace VitesseCms\Communication\Controllers;

use VitesseCms\Communication\Forms\NewsletterQueueForm;
use VitesseCms\Communication\Helpers\NewsletterQueueHelper;
use VitesseCms\Communication\Interfaces\RepositoriesInterface;
use VitesseCms\Communication\Models\NewsletterQueue;
use VitesseCms\Admin\AbstractAdminController;

class AdminnewsletterqueueController extends AbstractAdminController implements RepositoriesInterface
{
    /**
     * @var array
     */
    protected $parseAsJob = ['sendQueuedNewsletter'];

    public function onConstruct()
    {
        parent::onConstruct();

        $this->class = NewsletterQueue::class;
        $this->classForm = NewsletterQueueForm::class;

        $this->listTemplate = 'listNewsletterQueue';
        $this->listTemplatePath = $this->configuration->getVendorNameDir() . 'communication/src/resources/views/admin/';
    }

    public function viewBodyAction(string $id): void
    {
        $newsletterQueue = $this->repositories->newsletterQueue->getById($id, false);
        if ($newsletterQueue !== null) :
            $this->view->setVar('content', $newsletterQueue->getBodyField());
            $_REQUEST['embedded'] = 1;
        endif;

        parent::prepareView();
    }

    public function sendQueuedNewsletterAction(string $id): void
    {
        $newsletterQueue = $this->repositories->newsletterQueue->getById($id, false);
        if ($newsletterQueue !== null) :
            $now = new \DateTime();
            $newsletterQueue->setDateSending($now->format('Y-m-d H:i:s'))->save();

            if (NewsletterQueueHelper::send($newsletterQueue, $this->setting, $this->view)) :
                $newsletterQueue->setDateSent($now->format('Y-m-d H:i:s'))
                    ->setPublished(true)
                    ->save()
                ;
                $this->flash->setSucces('NEWSLETTER_SEND');
            else :
                $this->flash->setError('Newsletter not send');
            endif;
        endif;
    }
}
