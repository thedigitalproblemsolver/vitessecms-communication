<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Listeners\Controllers;

use Phalcon\Events\Event;
use VitesseCms\Admin\Forms\AdminlistFormInterface;
use VitesseCms\Communication\Controllers\AdminemailController;

final class AdminemailControllerListener
{
    public function adminListFilter(Event $event, AdminemailController $controller, AdminlistFormInterface $form): void
    {
        $form->addText(
            'Subject',
            'filter[subject.' . $form->configuration->getLanguageShort() . ']'
        );
        $form->addPublishedField($form);
    }
}
