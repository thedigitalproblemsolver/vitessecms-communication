<?php declare(strict_types=1);

namespace VitesseCms\Communication\Blocks;

use VitesseCms\Block\AbstractBlockModel;
use VitesseCms\Block\Models\Block;

class MailchimpInitialize extends AbstractBlockModel
{
    public function loadAssets(Block $block): void
    {
        if ($this->di->request->get('mc_cid')) :
            $this->di->session->set('mailchimpCampaignId', $this->di->request->get('mc_cid'));
        endif;
    }
}
