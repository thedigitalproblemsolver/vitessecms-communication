<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners;

use VitesseCms\Communication\Blocks\NewsletterSubscribe;
use VitesseCms\Communication\Controllers\AdminemailController;
use VitesseCms\Communication\Controllers\AdminnewsletterController;
use VitesseCms\Communication\Controllers\AdminnewsletterlistController;
use VitesseCms\Communication\Controllers\AdminnewsletterqueueController;
use VitesseCms\Communication\Controllers\AdminnewslettertemplateController;
use VitesseCms\Communication\Listeners\Controllers\AdminemailControllerListener;
use VitesseCms\Communication\Listeners\Admin\AdminMenuListener;
use VitesseCms\Communication\Listeners\Controllers\AdminnewsletterControllerListener;
use VitesseCms\Communication\Listeners\Controllers\AdminnewsletterlistControllerListener;
use VitesseCms\Communication\Listeners\Controllers\AdminnewsletterqueueControllerListener;
use VitesseCms\Communication\Listeners\Controllers\AdminnewsletterTemplateControllerListener;
use VitesseCms\Communication\Listeners\Blocks\BlockNewsletterSubscribeListener;
use VitesseCms\Communication\Repositories\NewsletterRepository;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;

class InitiateAdminListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        if($di->user->hasAdminAccess()):
            $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        endif;
        $di->eventsManager->attach(AdminnewsletterController::class, new AdminnewsletterControllerListener());
        $di->eventsManager->attach(AdminnewsletterqueueController::class, new AdminnewsletterqueueControllerListener());
        $di->eventsManager->attach(AdminnewsletterlistController::class, new AdminnewsletterlistControllerListener());
        $di->eventsManager->attach(AdminemailController::class, new AdminemailControllerListener());
        $di->eventsManager->attach(AdminnewslettertemplateController::class, new AdminnewsletterTemplateControllerListener());
        $di->eventsManager->attach(NewsletterSubscribe::class, new BlockNewsletterSubscribeListener(
            new NewsletterRepository()
        ));

    }
}
