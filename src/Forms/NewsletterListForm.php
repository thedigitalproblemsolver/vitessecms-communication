<?php declare(strict_types=1);

namespace VitesseCms\Communication\Forms;

use VitesseCms\Communication\Models\NewsletterList;
use VitesseCms\Communication\Repositories\RepositoryCollection;
use VitesseCms\Form\AbstractForm;
use VitesseCms\Form\AbstractFormWithRepository;
use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Interfaces\FormWithRepositoryInterface;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Language\Models\Language;
use VitesseCms\User\Models\User;

class NewsletterListForm extends AbstractFormWithRepository
{
    /**
     * @var RepositoryCollection
     */
    protected $repositories;

    /**
     * @var NewsletterList
     */
    protected $_entity;

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
            ->addHtml($this->_entity->getDataHtml() ?? '')
            ->addSubmitButton('submit', '%CORE_SAVE%');

        return $this;
    }
}
