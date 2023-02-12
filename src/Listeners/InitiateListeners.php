<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners;

use VitesseCms\Communication\Blocks\MailchimpInitialize;
use VitesseCms\Communication\Enums\NewsletterListEnum;
use VitesseCms\Communication\Listeners\Admin\AdminMenuListener;
use VitesseCms\Communication\Listeners\Blocks\BlockMailchimpInitializeListener;
use VitesseCms\Communication\Listeners\ContentTags\TagSubscribeListener;
use VitesseCms\Communication\Listeners\ContentTags\TagUnsubscribeListener;
use VitesseCms\Communication\Listeners\Modules\FormListener;
use VitesseCms\Communication\Repositories\NewsletterListRepository;
use VitesseCms\Communication\Repositories\NewsletterRepository;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Form\Enums\FormEnum;

class InitiateListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        if($di->user->hasAdminAccess()):
            $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        endif;
        $di->eventsManager->attach(MailchimpInitialize::class, new BlockMailchimpInitializeListener($di->request, $di->session));
        $di->eventsManager->attach('contentTag', new TagUnsubscribeListener());
        $di->eventsManager->attach('contentTag', new TagSubscribeListener());
        $di->eventsManager->attach(FormEnum::SERVICE_LISTENER->value, new FormListener(new NewsletterRepository()));
        $di->eventsManager->attach(NewsletterListEnum::SERVICE_LISTENER->value, new NewsletterListListener(new NewsletterListRepository()));
    }
}
