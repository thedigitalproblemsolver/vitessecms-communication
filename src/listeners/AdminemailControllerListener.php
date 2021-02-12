<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Admin\Forms\AdminlistFormInterface;
use VitesseCms\Communication\Controllers\AdminemailController;
use VitesseCms\Communication\Models\Email;
use VitesseCms\User\Utils\PermissionUtils;
use Phalcon\Events\Event;
use Phalcon\Tag;

class AdminemailControllerListener
{
    public function adminListItem(Event $event, AdminemailController $controller, Email $email): void
    {
        $email->setAdminListExtra($controller->view->renderTemplate(
            'emailAdminListItem',
            $controller->configuration->getVendorNameDir().'communication/src/resources/views/admin/',
            ['email' => $email]
        ));

        if (PermissionUtils::check(
            $controller->user,
            $controller->view->getVar('aclModulePrefix').'communication',
            'adminemail',
            'sendPreview'
        )) :
            $email->setExtraAdminListButtons(Tag::linkTo([
                'action' => '/admin/communication/adminemail/sendPreview/'.$email->getId(),
                'class'  => 'fa fa-envelope',
            ]));
        endif;
    }

    public function adminListFilter(
        Event $event,
        AbstractAdminController $controller,
        AdminlistFormInterface $form
    ): string
    {
        $form->addText(
            'Subject',
            'filter[subject.'. $form->configuration->getLanguageShort() .']'
        );
        $form->addPublishedField($form);

        return $form->renderForm(
            $controller->getLink() . '/' . $controller->router->getActionName(),
            'adminFilter'
        );
    }
}
