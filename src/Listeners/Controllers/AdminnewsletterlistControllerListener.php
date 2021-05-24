<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners\Controllers;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Admin\Forms\AdminlistFormInterface;
use VitesseCms\Communication\Controllers\AdminnewsletterlistController;
use VitesseCms\Communication\Models\NewsletterList;
use Phalcon\Events\Event;

class AdminnewsletterlistControllerListener
{
    public function beforeModelSave(Event $event, AdminnewsletterlistController $controller, NewsletterList $newsletterList): void
    {
        if ($controller->request->get('addEmail')) :
            $newsletterList->addMember($controller->request->get('addEmail'));
            $controller->log->write(
                $newsletterList->getId(),
                NewsletterList::class,
                'Added ' . $controller->request->get('addEmail') . ' to ' . $newsletterList->getNameField() . ' by admin'
            );
            $_POST['addEmail'] = null;
        endif;
    }

    public function beforeEdit(Event $event, AdminnewsletterlistController $controller, NewsletterList $newsletterList): void
    {
        $rows = [];
        foreach ($newsletterList->getMembers() as $key => $member) :
            $member['key'] = $key;
            $member['rowNumber'] = $key + 1;
            $member['rowState'] = 'list-group-item-success';
            if (!empty($member['unSubscribeDate'])) :
                $member['rowState'] = 'list-group-item-danger';
            endif;
            $rows[] = $member;
        endforeach;

        $link = $controller->url->getBaseUri() .
            'admin/' .
            $controller->router->getModuleName() .
            '/' . $controller->router->getControllerName();
        $dataHtml = $controller->view->renderTemplate(
            'adminNewsletterListMembers',
            $controller->configuration->getVendorNameDir() . 'communication/src/Resources/views/admin/',
            [
                'baseLink' => $link,
                'baseId' => (string)$newsletterList->getId(),
                'rows' => $rows
            ]
        );

        $newsletterList->setDataHtml($dataHtml);
    }

    public function adminListFilter(
        Event $event,
        AbstractAdminController $controller,
        AdminlistFormInterface $form
    ): string
    {
        $form->addText('%CORE_NAME%', 'filter[name]');
        $form->addPublishedField($form);

        return $form->renderForm(
            $controller->getLink() . '/' . $controller->router->getActionName(),
            'adminFilter'
        );
    }
}
