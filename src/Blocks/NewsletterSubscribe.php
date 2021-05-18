<?php declare(strict_types=1);

namespace VitesseCms\Communication\Blocks;

use VitesseCms\Block\AbstractBlockModel;
use VitesseCms\Block\Models\Block;
use VitesseCms\Communication\Helpers\NewsletterHelper;
use VitesseCms\Communication\Models\Newsletter;

class NewsletterSubscribe extends AbstractBlockModel
{
    public function initialize()
    {
        parent::initialize();

        $this->excludeFromCache = true;
    }

    public function parse(Block $block): void
    {
        parent::parse($block);

        $redirect = true;
        if ($this->di->request->get('e')) :
            $email = base64_decode($this->di->request->get('e'));
            if ($email) :
                foreach ((array)$block->_('subscribe') as $newsletterId) :
                    /** @var Newsletter $newsletter */
                    $newsletter = Newsletter::findById($newsletterId);
                    if ($newsletter) :
                        NewsletterHelper::addMemberByEmail($newsletter, $email);
                    endif;
                    $redirect = false;
                endforeach;
                foreach ((array)$block->_('unsubscribe') as $newsletterId) :
                    /** @var Newsletter $newsletter */
                    $newsletter = Newsletter::findById($newsletterId);
                    if ($newsletter) :
                        NewsletterHelper::unsubscribeMemberByEmail($newsletter, $email);
                    endif;
                    $redirect = false;
                endforeach;
                foreach ((array)$block->_('remove') as $newsletterId) :
                    /** @var Newsletter $newsletter */
                    $newsletter = Newsletter::findById($newsletterId);
                    if ($newsletter) :
                        NewsletterHelper::removeMemberByEmail($newsletter, $email);
                    endif;
                    $redirect = false;
                endforeach;
            endif;
        endif;

        if ($redirect && !$this->di->user->hasAdminAccess()) :
            $this->di->response->redirect($this->di->url->getBaseUri())->send();
            die();
        endif;
    }
}
