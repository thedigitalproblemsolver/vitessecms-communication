<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners\Admin;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Admin\Forms\AdminlistFormInterface;
use VitesseCms\Communication\Controllers\AdminnewsletterqueueController;
use VitesseCms\Communication\Models\Newsletter;
use VitesseCms\Communication\Models\NewsletterQueue;
use Phalcon\Events\Event;
use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Models\Attributes;

class AdminnewsletterqueueControllerListener
{
    public function adminListItem(
        Event $event,
        AdminnewsletterqueueController $controller,
        NewsletterQueue $newsletterQueue
    ): void
    {
        $newsletterQueue->setAdminListExtra($controller->view->renderModuleTemplate(
            'communication',
            'newsletterQueueAdminListItem',
            'admin/',
            ['newsletterQueue' => $newsletterQueue]
        ));

        $newsletterQueue->setAdminListName($newsletterQueue->getEmail());
    }

    public function adminListFilter(
        Event $event,
        AbstractAdminController $controller,
        AdminlistFormInterface $form
    ): string
    {
        $form->addEmail('%CORE_EMAIL%', 'filter[email]')
            ->addDropdown(
                'Newsletter',
                'filter[newsletterId]',
                (new Attributes())->setOptions(ElementHelper::arrayToSelectOptions(Newsletter::findAll())
                )
            );

        return $form->renderForm(
            $controller->getLink() . '/' . $controller->router->getActionName(),
            'adminFilter'
        );
    }
}
