<?php declare(strict_types=1);

namespace VitesseCms\Communication\Forms;

use VitesseCms\Communication\Models\Newsletter;
use VitesseCms\Communication\Models\NewsletterList;
use VitesseCms\Communication\Models\NewsletterQueue;
use VitesseCms\Communication\Repositories\RepositoryCollection;
use VitesseCms\Form\AbstractForm;
use VitesseCms\Form\AbstractFormWithRepository;
use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Interfaces\FormWithRepositoryInterface;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\User\Models\User;

class NewsletterQueueForm extends AbstractFormWithRepository
{
    public function buildForm(): FormWithRepositoryInterface
    {
        $this->addText('%CORE_EMAIL%', 'email', (new Attributes())->setReadonly(true))
            ->addDropdown(
                'User',
                'userId',
                (new Attributes())
                    ->setReadonly(true)
                    ->setOptions(ElementHelper::arrayToSelectOptions(User::findAll())))
            ->addDropdown(
                'Newsletter',
                'newsletterId',
                (new Attributes())
                    ->setReadonly(true)
                    ->setOptions(ElementHelper::arrayToSelectOptions(Newsletter::findAll())))
            ->addDropdown(
                'Newsletter list',
                'newsletterListId',
                (new Attributes())
                    ->setReadonly(true)
                    ->setOptions(ElementHelper::arrayToSelectOptions(NewsletterList::findAll())))
            ->addText('Date sending', 'dateSending', (new Attributes())->setReadonly(true))
            ->addText('Date sent', 'dateSent', (new Attributes())->setReadonly(true))
            ->addText('Date opened', 'dateOpened', (new Attributes())->setReadonly(true))
            ->addText('Subject', 'subject', (new Attributes())->setReadonly(true))
            ->addText('Job Queue id', 'jobId', (new Attributes())->setReadonly(true));

        return $this;
    }
}
