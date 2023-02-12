<?php declare(strict_types=1);

namespace VitesseCms\Communication\Controllers;

use VitesseCms\Communication\Repositories\RepositoriesInterface;
use VitesseCms\Core\AbstractController;
use VitesseCms\Core\AbstractControllerFrontend;
use VitesseCms\Form\Controllers\IndexController;
use VitesseCms\Form\Utils\FormUtil;

class NewsletterlistController extends AbstractControllerFrontend
{
    public function onConstruct()
    {
        parent::onConstruct();
    }

    public function unsubscribeAction(string $newsletterListId): void
    {
        if ($this->user->isLoggedIn()) :
            $newsletterList = $this->repositories->newsletterList->getById($newsletterListId);
            if ($newsletterList !== null):
                $newsletterList->unsubscribeMember($this->user->getEmail())->save();
                $this->flash->setSucces('NEWSLETTER_UNSUBSCRIBE_SUCCESS', 'success', [$newsletterList->_('name')]);
            endif;
        endif;

        $this->redirect();
    }

    public function subscribeAction(string $newsletterListId): void
    {
        if ($this->user->isLoggedIn()) :
            $newsletterList = $this->repositories->newsletterList->getById($newsletterListId);
            if ($newsletterList !== null) :
                $newsletterList->subscribeMember($this->user->getEmail())->save();
                $this->flash->setSucces('NEWSLETTER_SUBSCRIBE_SUCCESS', 'success', [$newsletterList->_('name')]);
            endif;
        endif;

        $this->redirect();
    }
}
