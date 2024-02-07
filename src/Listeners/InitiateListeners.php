<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Listeners;

use VitesseCms\Communication\Blocks\MailchimpInitialize;
use VitesseCms\Communication\Enums\NewsletterListEnum;
use VitesseCms\Communication\Enums\NewsletterQueueEnum;
use VitesseCms\Communication\Listeners\Admin\AdminMenuListener;
use VitesseCms\Communication\Listeners\Blocks\BlockMailchimpInitializeListener;
use VitesseCms\Communication\Listeners\ContentTags\TagSubscribeListener;
use VitesseCms\Communication\Listeners\ContentTags\TagUnsubscribeListener;
use VitesseCms\Communication\Listeners\Modules\FormListener;
use VitesseCms\Communication\Repositories\NewsletterListRepository;
use VitesseCms\Communication\Repositories\NewsletterQueueRepository;
use VitesseCms\Communication\Repositories\NewsletterRepository;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Form\Enums\FormEnum;

final class InitiateListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $injectable): void
    {
        if ($injectable->user->hasAdminAccess()):
            $injectable->eventsManager->attach('adminMenu', new AdminMenuListener());
        endif;
        $injectable->eventsManager->attach(
            MailchimpInitialize::class,
            new BlockMailchimpInitializeListener($injectable->request, $injectable->session)
        );
        $injectable->eventsManager->attach('contentTag', new TagUnsubscribeListener());
        $injectable->eventsManager->attach('contentTag', new TagSubscribeListener());
        $injectable->eventsManager->attach(
            FormEnum::SERVICE_LISTENER->value,
            new FormListener(new NewsletterRepository())
        );
        $injectable->eventsManager->attach(
            NewsletterListEnum::SERVICE_LISTENER->value,
            new NewsletterListListener(new NewsletterListRepository())
        );
        $injectable->eventsManager->attach(
            NewsletterQueueEnum::SERVICE_LISTENER->value,
            new NewsletterQueueListener(new NewsletterQueueRepository())
        );
    }
}
