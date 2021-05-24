<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners;

use Phalcon\Events\Event;
use VitesseCms\Block\Forms\BlockForm;
use VitesseCms\Block\Models\Block;
use VitesseCms\Database\Models\FindValue;
use VitesseCms\Database\Models\FindValueIterator;
use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Models\Attributes;

class BlockNewsletterSubscribeListener
{
    public function buildBlockForm(Event $event, BlockForm $form, Block $block): void
    {
        $newsletters = $block->getDi()->repositories->newsletter->findAll(new FindValueIterator(
            [new FindValue('parentId', null)]
        ));
        $attributes = new Attributes();
        $attributes->setMultilang(true)->setOptions(ElementHelper::modelIteratorToOptions($newsletters));
        $attributes->setMultiple(true);

        $form->addDropdown('Newsletters to subscribe', 'subscribe', $attributes)
            ->addDropdown('Newsletters to unsubscribe', 'unsubscribe', $attributes)
            ->addDropdown('Newsletters to remove', 'remove', $attributes)
        ;
    }
}
