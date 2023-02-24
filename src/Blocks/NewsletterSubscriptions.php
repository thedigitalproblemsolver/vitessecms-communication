<?php declare(strict_types=1);

namespace VitesseCms\Communication\Blocks;

use Phalcon\Di\Di;
use VitesseCms\Block\AbstractBlockModel;
use VitesseCms\Block\Models\Block;
use VitesseCms\Communication\Enums\NewsletterListEnum;
use VitesseCms\Communication\Repositories\NewsletterListRepository;
use VitesseCms\Core\Services\ViewService;

class NewsletterSubscriptions extends AbstractBlockModel
{
    private readonly NewsletterListRepository $newsletterListRepository;
    public function __construct(ViewService $view, Di $di)
    {
        parent::__construct($view, $di);
        $this->newsletterListRepository = $di->get('eventsManager')->fire(NewsletterListEnum::GET_REPOSITORY->value, new \stdClass());
    }

    public function parse(Block $block): void
    {
        parent::parse($block);

        if(is_array($this->getDi()->get('user')->_('newsletterLists'))) :
            $newsletterLists = array_values($this->getDi()->get('user')->_('newsletterLists'));
            foreach ($newsletterLists as $key => $newsletterListArray) :
                $newsletterList = $this->newsletterListRepository->getById($newsletterListArray['newsletterListId']);
                $newsletterLists[$key]['newsletterListName'] = $newsletterList->getNameField();
            endforeach;
            $block->set('newsletterLists', $newsletterLists);
        endif;
    }
}
