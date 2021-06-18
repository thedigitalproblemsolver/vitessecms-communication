<?php declare(strict_types=1);

namespace VitesseCms\Communication\Fields;

use VitesseCms\Datafield\Models\Datafield;
use VitesseCms\Database\AbstractCollection;
use VitesseCms\Datafield\AbstractField;
use VitesseCms\Form\AbstractForm;
use VitesseCms\Form\Models\Attributes;

class SocialShare extends AbstractField
{
    public function buildItemFormElement(
        AbstractForm $form,
        Datafield $datafield,
        Attributes $attributes,
        AbstractCollection $data = null
    )
    {
        $form->addToggle('Share on Twitter', $datafield->getCallingName().'_twitter', $attributes);
    }
}
