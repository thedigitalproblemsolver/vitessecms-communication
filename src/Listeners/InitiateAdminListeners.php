<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners;

use Phalcon\Events\Manager;
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

class InitiateAdminListeners
{
    public static function setListeners(Manager $eventsManager): void
    {
        $eventsManager->attach('adminMenu', new AdminMenuListener());
        $eventsManager->attach(AdminnewsletterController::class, new AdminnewsletterControllerListener());
        $eventsManager->attach(AdminnewsletterqueueController::class, new AdminnewsletterqueueControllerListener());
        $eventsManager->attach(AdminnewsletterlistController::class, new AdminnewsletterlistControllerListener());
        $eventsManager->attach(AdminemailController::class, new AdminemailControllerListener());
        $eventsManager->attach(AdminnewslettertemplateController::class, new AdminnewsletterTemplateControllerListener());
        $eventsManager->attach(NewsletterSubscribe::class, new BlockNewsletterSubscribeListener(
            new NewsletterRepository()
        ));

    }
}
