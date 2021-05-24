<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners;

use Phalcon\Events\Manager;
use Phalcon\Http\Request;
use VitesseCms\Communication\Blocks\MailchimpInitialize;
use VitesseCms\Communication\Listeners\Admin\AdminMenuListener;
use VitesseCms\Communication\Listeners\Blocks\BlockMailchimpInitializeListener;
use Phalcon\Session\Adapter\Files as Session;

class InitiateListeners
{
    public static function setListeners(Manager $eventsManager): void
    {
        $eventsManager->attach('adminMenu', new AdminMenuListener());
        $eventsManager->attach(MailchimpInitialize::class, new BlockMailchimpInitializeListener(
            new Request(),
            new Session()
        ));
    }
}
