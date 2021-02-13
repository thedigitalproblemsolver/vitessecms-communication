<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners;

use Phalcon\Events\Manager;
use VitesseCms\Communication\Controllers\AdminemailController;
use VitesseCms\Communication\Controllers\AdminnewsletterController;
use VitesseCms\Communication\Controllers\AdminnewsletterlistController;
use VitesseCms\Communication\Controllers\AdminnewsletterqueueController;
use VitesseCms\Communication\Controllers\AdminnewslettertemplateController;

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
    }
}
