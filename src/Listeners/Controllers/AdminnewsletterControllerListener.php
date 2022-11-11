<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners\Controllers;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Admin\Forms\AdminlistFormInterface;
use VitesseCms\Communication\Controllers\AdminnewsletterController;
use VitesseCms\Communication\Models\Newsletter;
use Phalcon\Events\Event;
use VitesseCms\Mustache\DTO\RenderTemplateDTO;
use VitesseCms\Mustache\Enum\ViewEnum;

class AdminnewsletterControllerListener
{
    public function beforeEdit(Event $event, AdminnewsletterController $controller, Newsletter $newsletter): void
    {
        if (
            !empty($newsletter->getLanguage())
            && !empty($newsletter->getTemplate())
            && empty($newsletter->getBody())
        ) :
            $newsletterTemplate = $controller->repositories->newsletterTemplate->getById($newsletter->getTemplate());
            if ($newsletterTemplate !== null):
                $newsletter->setBody($newsletterTemplate->getTemplate());
            endif;
        endif;
    }

    public function beforePostBinding(Event $event, AdminnewsletterController $controller, Newsletter $newsletter): void
    {
        if (empty($controller->request->get('emailHeaderImage'))) :
            unset($_POST['emailHeaderImage']);
        endif;
    }

    public function adminListItem(Event $event, AdminnewsletterController $controller, Newsletter $newsletter): void
    {
        $language = $controller->repositories->language->getById(
            $newsletter->getLanguage()
        );

        $adminListExtra = $controller->eventsManager->fire(ViewEnum::RENDER_TEMPLATE_EVENT, new RenderTemplateDTO(
            'newsletterAdminListItem',
            $controller->router->getModuleName() . '/src/Resources/views/admin/',
            [
                'newsletter' => $newsletter,
                'languageShort' => $language ? $language->getShortCode() : '',
                'listSortable' => $controller->isListSortable(),
            ]
        ));

        $newsletter->setAdminListExtra($adminListExtra);
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
