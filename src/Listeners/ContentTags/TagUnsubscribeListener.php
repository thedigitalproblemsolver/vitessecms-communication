<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners\ContentTags;

use VitesseCms\Content\Helpers\EventVehicleHelper;
use VitesseCms\Content\Listeners\ContentTags\AbstractTagListener;

class TagUnsubscribeListener extends AbstractTagListener
{
    public function __construct()
    {
        $this->name = 'UNSUBSCRIBE';
    }

    protected function parse(EventVehicleHelper $eventVehicle, string $tagString): void
    {
        $unsubscribeLink = $eventVehicle->getUrl()->getBaseUri() .
            'communication/newsletterqueue/unsubscribe/' .
            $eventVehicle->_('newsletterQueueId');

        $content = str_replace(
            ['{UNSUBSCRIBE}', '{/UNSUBSCRIBE}'],
            ['<a href="' . $unsubscribeLink . '" class="link-unsubscribe" style="text-decoration:none" target="_blank" >', '</a>'],
            $eventVehicle->_('content')
        );
        $eventVehicle->set('content', $content);
    }
}
