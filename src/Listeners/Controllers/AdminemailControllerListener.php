<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Listeners\Controllers;

use Phalcon\Events\Event;
use VitesseCms\Admin\Forms\AdminlistFormInterface;
use VitesseCms\Communication\Controllers\AdminemailController;

class AdminemailControllerListener
{
    /*public function adminListItem(Event $event, AdminemailController $controller, Email $email): void
    {
        $email->setAdminListExtra(
            $controller->view->renderTemplate(
                'emailAdminListItem',
                $controller->configuration->getVendorNameDir() . 'communication/src/Resources/views/admin/',
                ['email' => $email]
            )
        );

        if (PermissionUtils::check(
            $controller->user,
            $controller->view->getVar('aclModulePrefix') . 'communication',
            'adminemail',
            'sendPreview'
        )) :
            $email->setExtraAdminListButtons(
                Tag::linkTo([
                    'action' => '/Admin/communication/adminemail/sendPreview/' . $email->getId(),
                    'class' => 'fa fa-envelope',
                ])
            );
        endif;
    }*/

    public function adminListFilter(Event $event, AdminemailController $controller, AdminlistFormInterface $form): void
    {
        $form->addText(
            'Subject',
            'filter[subject.' . $form->configuration->getLanguageShort() . ']'
        );
        $form->addPublishedField($form);
    }
}
