<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners\Admin;

use Phalcon\Events\Event;
use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Admin\Forms\AdminlistFormInterface;
use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Models\Attributes;

class AdminnewsletterTemplateControllerListener
{
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
