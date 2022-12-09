<?php declare(strict_types=1);

namespace VitesseCms\Communication\Forms;

use VitesseCms\Communication\Models\EmailTemplate;
use VitesseCms\Communication\Models\NewsletterTemplate;
use VitesseCms\Communication\Repositories\RepositoryCollection;
use VitesseCms\Form\AbstractForm;
use VitesseCms\Form\AbstractFormWithRepository;
use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Interfaces\FormWithRepositoryInterface;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Language\Models\Language;

class NewsletterTemplateForm extends AbstractFormWithRepository
{
    public function buildForm(): FormWithRepositoryInterface
    {
        $this->addText('%CORE_NAME%', 'name', (new Attributes())->setRequired(true))
            ->addDropdown(
                '%ADMIN_LANGUAGE%',
                'language',
                (new Attributes())->setRequired(true)
                    ->setOptions(ElementHelper::modelIteratorToOptions($this->repositories->language->findAll())
                    ))
            ->addEditor('template', 'template', (new Attributes())->setRequired(true))
            ->addSubmitButton('%CORE_SAVE%');

        return $this;
    }
}
