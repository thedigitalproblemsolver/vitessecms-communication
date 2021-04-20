<?php declare(strict_types=1);

namespace VitesseCms\Communication\Forms;

use VitesseCms\Block\Utils\BlockUtil;
use VitesseCms\Communication\Interfaces\RepositoriesInterface;
use VitesseCms\Communication\Interfaces\RepositoryInterface;
use VitesseCms\Communication\Models\Newsletter;
use VitesseCms\Communication\Models\NewsletterList;
use VitesseCms\Communication\Models\NewsletterTemplate;
use VitesseCms\Content\Models\Item;
use VitesseCms\Core\Helpers\ItemHelper;
use VitesseCms\Core\Utils\SystemUtil;
use VitesseCms\Database\Models\FindValue;
use VitesseCms\Database\Models\FindValueIterator;
use VitesseCms\Form\AbstractForm;
use VitesseCms\Form\AbstractFormWithRepository;
use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Interfaces\FormWithRepositoryInterface;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Language\Models\Language;

class NewsletterForm extends AbstractFormWithRepository
{
    /**
     * @var RepositoryInterface
     */
    protected $repositories;

    /**
     * @var Newsletter
     */
    protected $item;

    public function buildForm(): FormWithRepositoryInterface
    {
        if ($this->item === null || $this->item->getParentId() === null) {
            $this->buildParentForm();
        } else {
            $this->buildChildForm();
        }
        if ($this->request->get('parentId', null)) :
            $this->addHidden('parentId', $this->request->get('parentId'));
        endif;

        return $this;
    }

    protected function buildParentForm(): void
    {
        $showSendNewsletterList = false;

        $this->addText('%CORE_NAME%', 'name', (new Attributes())->setRequired(true))
            ->addDropdown(
                '%ADMIN_LANGUAGE%',
                'language',
                (new Attributes())->setRequired(true)
                    ->setOptions(ElementHelper::modelIteratorToOptions($this->repositories->language->findAll())
                    ));

        if ($this->item->getLanguage() !== null) :
            $newsletters = $this->repositories->newsletterList->findAll(
                new FindValueIterator([new FindValue('language', $this->item->getLanguage())])
            );
            $this->addDropdown(
                'Newsletter list',
                'list',
                (new Attributes())->setOptions(ElementHelper::modelIteratorToOptions($newsletters))
            );
            if (!$this->item->hasChildren) :
                $this->setBodyText();
            endif;
            $showSendNewsletterList = true;
        endif;

        $this->addToggle('Start sending after subscribtion', 'sendAfterSubscribtion')
            ->addSubmitButton('%CORE_SAVE%')
            ->addHtml('<span id="newsletterId" style="display:none">' . $this->item->getId() . '</span>');

        if ($showSendNewsletterList) :
            if (!$this->item->hasChildren()) :
                $this->addDate('Senddate', 'sendDate')
                    ->addDate('Sendtime', 'sendTime');
            endif;
            if ($this->item->isPublished()) :
                $this->addButton('Place newsletter in  queue', 'queueNewsletter');
            endif;
        endif;
    }

    protected function setBodyText(): void
    {
        $newsletterTemplates = $this->repositories->newsletterTemplate->findAll(
            new FindValueIterator([new FindValue('language', $this->item->getLanguage())])
        );
        $this->addDropdown(
            '%ADMIN_CHOOSE_A_TEMPLATE%',
            'template',
            (new Attributes())->setOptions(ElementHelper::modelIteratorToOptions($newsletterTemplates))
        );
        $files = BlockUtil::getTemplateFiles('../emails', $this->configuration);

        $options = [];
        foreach ($files as $key => $label) :
            $selected = false;
            if ($this->item->getEmailType() === $key) :
                $selected = true;
            endif;
            $options[] = [
                'value' => $key,
                'label' => $label,
                'selected' => $selected,
            ];
        endforeach;
        $this->addDropdown(
            'Email type',
            'emailType',
            (new Attributes())->setRequired(true)->setOptions($options)
        )->addText('Subject', 'subject', (new Attributes())->setRequired(true))
            ->addText('Motto', 'motto', (new Attributes())->setRequired(true));

        if ($this->item->getTemplate() !== null) :
            $options = [[
                'value' => '',
                'label' => '%ADMIN_TYPE_TO_SEARCH%',
                'selected' => false,
            ]];

            if (!empty($this->item->getEmailHeaderTargetPage())) :
                $selectedItem = $this->repositories->item->getById($this->item->getEmailHeaderTargetPage());
                $itemPath = ItemHelper::getPathFromRoot($selectedItem);
                $options[] = [
                    'value' => (string)$selectedItem->getId(),
                    'label' => implode(' - ', $itemPath),
                    'selected' => true,

                ];
            endif;

            $this->addEditor('Body', 'body', (new Attributes())->setRequired(true))
                ->addFilemanager('Header Image', 'emailHeaderImage')
                ->addDropdown(
                    'Header Target page',
                    'emailHeaderTargetPage',
                    (new Attributes())->setOptions($options)
                        ->setInputClass('select2-ajax')
                        ->setDataUrl('/content/index/search/')
                );
        endif;

        $this->addEmail('Send preview to', 'previewEmail')
            ->addButton('Send preview', 'sendPreviewEmail');
    }

    protected function buildChildForm(): void
    {
        $parentNewsletter = $this->repositories->newsletter->getById($this->item->getParentId());
        $this->item->setLanguage($parentNewsletter->getLanguage());
        $this->item->set('list', $parentNewsletter->_('list'));

        $this->addText('%CORE_NAME%', 'name', (new Attributes())->setRequired(true))
            ->addHidden('language', $parentNewsletter->getLanguage())
            ->addHidden('list', $parentNewsletter->getList());

        if ($this->item !== null && $this->item->getLanguage() !== null) :
            $this->setBodyText();
        endif;

        $this->addNumber('days after previous mail', 'days', (new Attributes())->setMin(0)->setStep(1))
            ->addTime('Sendtime', 'sendTime')
            ->addSubmitButton('%CORE_SAVE%')
            ->addHtml('<span id="newsletterId" style="display:none">' . $this->item->getId() . '</span>');
    }

    public function setEntity($entity)
    {
        parent::setEntity($entity);
        $this->item = $entity;
    }
}
