<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Listeners;

use VitesseCms\Communication\Blocks\NewsletterSubscribe;
use VitesseCms\Communication\Controllers\AdminemailController;
use VitesseCms\Communication\Controllers\AdminnewsletterController;
use VitesseCms\Communication\Controllers\AdminnewsletterlistController;
use VitesseCms\Communication\Controllers\AdminnewsletterqueueController;
use VitesseCms\Communication\Controllers\AdminnewslettertemplateController;
use VitesseCms\Communication\Enums\EmailEnum;
use VitesseCms\Communication\Enums\NewsletterListEnum;
use VitesseCms\Communication\Listeners\Admin\AdminMenuListener;
use VitesseCms\Communication\Listeners\Blocks\BlockNewsletterSubscribeListener;
use VitesseCms\Communication\Listeners\Controllers\AdminemailControllerListener;
use VitesseCms\Communication\Listeners\Controllers\AdminnewsletterControllerListener;
use VitesseCms\Communication\Listeners\Controllers\AdminnewsletterlistControllerListener;
use VitesseCms\Communication\Listeners\Controllers\AdminnewsletterqueueControllerListener;
use VitesseCms\Communication\Listeners\Controllers\AdminnewsletterTemplateControllerListener;
use VitesseCms\Communication\Listeners\Models\EmailListener;
use VitesseCms\Communication\Listeners\Models\UserListener;
use VitesseCms\Communication\Models\Email;
use VitesseCms\Communication\Repositories\NewsletterListRepository;
use VitesseCms\Communication\Repositories\NewsletterQueueRepository;
use VitesseCms\Communication\Repositories\NewsletterRepository;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\User\Models\User;

final class InitiateAdminListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $injectable): void
    {
        $injectable->eventsManager->attach('adminMenu', new AdminMenuListener());
        $injectable->eventsManager->attach(AdminnewsletterController::class, new AdminnewsletterControllerListener());
        $injectable->eventsManager->attach(
            AdminnewsletterqueueController::class,
            new AdminnewsletterqueueControllerListener()
        );
        $injectable->eventsManager->attach(
            AdminnewsletterlistController::class,
            new AdminnewsletterlistControllerListener()
        );
        $injectable->eventsManager->attach(AdminemailController::class, new AdminemailControllerListener());
        $injectable->eventsManager->attach(
            AdminnewslettertemplateController::class,
            new AdminnewsletterTemplateControllerListener()
        );
        $injectable->eventsManager->attach(
            NewsletterSubscribe::class,
            new BlockNewsletterSubscribeListener(
                new NewsletterRepository()
            )
        );
        $injectable->eventsManager->attach(
            User::class,
            new UserListener($injectable->log, new NewsletterListRepository(), new NewsletterQueueRepository())
        );
        $injectable->eventsManager->attach(
            NewsletterListEnum::SERVICE_LISTENER->value,
            new NewsletterListListener(new NewsletterListRepository())
        );
        $injectable->eventsManager->attach(EmailEnum::LISTENER->value, new EmailListener(Email::class));
    }
}
