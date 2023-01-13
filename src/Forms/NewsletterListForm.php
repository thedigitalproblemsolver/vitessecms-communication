<?php declare(strict_types=1);

namespace VitesseCms\Communication\Forms;

use VitesseCms\Communication\Models\NewsletterList;
use VitesseCms\Communication\Repositories\RepositoryCollection;
use VitesseCms\Form\AbstractFormWithRepository;
use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Interfaces\FormWithRepositoryInterface;
use VitesseCms\Form\Models\Attributes;

class NewsletterListForm extends AbstractFormWithRepository
{
    public function buildForm(): FormWithRepositoryInterface
    {
        $this->addText('%CORE_NAME%', 'name', (new Attributes())->setRequired(true))
            ->addDropdown(
                '%ADMIN_LANGUAGE%',
                'language',
                (new Attributes())->setRequired(true)
                    ->setOptions(
                        ElementHelper::modelIteratorToOptions($this->repositories->language->findAll())))
            ->addEmail('%CORE_EMAIL%', 'addEmail')
            ->addHtml($this->entity->getDataHtml() ?? '')
            ->addSubmitButton('%CORE_SAVE%');

        return $this;
    }
}
