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
    public static function setListeners(InjectableInterface $di): void
    {
        $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        $di->eventsManager->attach(AdminnewsletterController::class, new AdminnewsletterControllerListener());
        $di->eventsManager->attach(AdminnewsletterqueueController::class, new AdminnewsletterqueueControllerListener());
        $di->eventsManager->attach(AdminnewsletterlistController::class, new AdminnewsletterlistControllerListener());
        $di->eventsManager->attach(AdminemailController::class, new AdminemailControllerListener());
        $di->eventsManager->attach(
            AdminnewslettertemplateController::class,
            new AdminnewsletterTemplateControllerListener()
        );
        $di->eventsManager->attach(
            NewsletterSubscribe::class,
            new BlockNewsletterSubscribeListener(
                new NewsletterRepository()
            )
        );
        $di->eventsManager->attach(
            User::class,
            new UserListener($di->log, new NewsletterListRepository(), new NewsletterQueueRepository())
        );
        $di->eventsManager->attach(
            NewsletterListEnum::SERVICE_LISTENER->value,
            new NewsletterListListener(new NewsletterListRepository())
        );
        $di->eventsManager->attach(EmailEnum::LISTENER->value, new EmailListener(Email::class));
    }
}
