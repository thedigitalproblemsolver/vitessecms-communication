<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners\Blocks;

use Phalcon\Events\Event;
use Phalcon\Http\Request;
use Phalcon\Session\Adapter\Files as Session;

class BlockMailchimpInitializeListener
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Session
     */
    private $session;

    public function __construct(Request $request, Session $session)
    {
        $this->request = $request;
        $this->session= $session;
    }

    public function loadAssets(Event $event): void
    {
        if ($this->request->get('mc_cid')) :
            $this->session->set('mailchimpCampaignId', $this->request->get('mc_cid'));
        endif;
    }
}