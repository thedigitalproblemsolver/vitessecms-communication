<?php declare(strict_types=1);

namespace VitesseCms\Communication\Forms;

use VitesseCms\Communication\Models\NewsletterList;
use VitesseCms\Communication\Repositories\RepositoryCollection;
use VitesseCms\Form\AbstractForm;
use VitesseCms\Form\AbstractFormWithRepository;
use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Interfaces\FormWithRepositoryInterface;
use VitesseCms\Form\Models\Attributes;

class NewsletterListImportForm extends AbstractFormWithRepository
{
    /**
     * @var RepositoryCollection
     */
    protected $reposotories;

    /**
     * @var NewsletterList
     */
    protected $_entity;

    public function buildForm(): FormWithRepositoryInterface
    {
        $this->addDropdown(
            'NewsletterList',
            'newsletterlist',
            (new Attributes())->setRequired(true)
                ->setOptions(ElementHelper::modelIteratorToOptions($this->repositories->newsletterList->findAll())
                ))
            ->addUpload('Importfile', 'file', (new Attributes())->setRequired(true))
            ->addSubmitButton('Import file')
        ;

        return $this;
    }
}
