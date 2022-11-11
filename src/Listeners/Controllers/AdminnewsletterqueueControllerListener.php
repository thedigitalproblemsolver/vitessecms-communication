<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners\Controllers;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Admin\Forms\AdminlistFormInterface;
use VitesseCms\Communication\Controllers\AdminnewsletterqueueController;
use VitesseCms\Communication\Models\Newsletter;
use VitesseCms\Communication\Models\NewsletterQueue;
use Phalcon\Events\Event;
use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Mustache\DTO\RenderTemplateDTO;
use VitesseCms\Mustache\Enum\ViewEnum;

class AdminnewsletterqueueControllerListener
{
    public function adminListItem(
        Event $event,
        AdminnewsletterqueueController $controller,
        NewsletterQueue $newsletterQueue
    ): void
    {
        $adminListExtra = $controller->eventsManager->fire(ViewEnum::RENDER_TEMPLATE_EVENT, new RenderTemplateDTO(
            'newsletterQueueAdminListItem',
            $controller->router->getModuleName() . '/src/Resources/views/admin/',
            ['newsletterQueue' => $newsletterQueue]
        ));
        $newsletterQueue->setAdminListExtra($adminListExtra);
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
