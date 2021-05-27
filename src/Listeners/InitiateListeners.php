<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners;

use VitesseCms\Communication\Blocks\MailchimpInitialize;
use VitesseCms\Communication\Listeners\Admin\AdminMenuListener;
use VitesseCms\Communication\Listeners\Blocks\BlockMailchimpInitializeListener;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;

class InitiateListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        if($di->user->hasAdminAccess()):
            $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        endif;
        $di->eventsManager->attach(MailchimpInitialize::class, new BlockMailchimpInitializeListener($di->request, $di->session));
    }
}
