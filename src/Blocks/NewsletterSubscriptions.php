<?php declare(strict_types=1);

namespace VitesseCms\Communication\Blocks;

use VitesseCms\Block\AbstractBlockModel;
use VitesseCms\Block\Models\Block;
use VitesseCms\Communication\Models\NewsletterList;

class NewsletterSubscriptions extends AbstractBlockModel
{
    public function initialize()
    {
        parent::initialize();

        $this->excludeFromCache = true;
    }

    public function parse(Block $block): void
    {
        parent::parse($block);

        if(is_array($this->di->user->_('newsletterLists'))) :
            $newsletterLists = array_values($this->di->user->_('newsletterLists'));
            foreach ($newsletterLists as $key => $newsletterListArray) :
                /** @var NewsletterList $newletterList */
                $newletterList = NewsletterList::findById($newsletterListArray['newsletterListId']);
                $newsletterLists[$key]['newsletterListName'] = $newletterList->getNameField();
            endforeach;
            $block->set('newsletterLists', $newsletterLists);
        endif;
    }
}
