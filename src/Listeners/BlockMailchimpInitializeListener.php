<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners;

use Phalcon\Events\Event;
use VitesseCms\Block\Models\Block;

class BlockMailchimpInitializeListener
{
    public function loadAssets(Event $event, Block $block): void
    {
        if ($block->getDI()->get('request')->get('mc_cid')) :
            $block->getDI()->get('session')->set('mailchimpCampaignId', $block->getDI()->get('request')->get('mc_cid'));
        endif;
    }
}