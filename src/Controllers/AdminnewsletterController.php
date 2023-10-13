<?php
declare(strict_types=1);

namespace VitesseCms\Communication\Controllers;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Communication\Factories\NewsletterQueueFactory;
use VitesseCms\Communication\Forms\NewsletterForm;
use VitesseCms\Communication\Helpers\NewsletterHelper;
use VitesseCms\Communication\Helpers\NewsletterQueueHelper;
use VitesseCms\Communication\Models\Newsletter;
use VitesseCms\Communication\Repositories\RepositoriesInterface;
use VitesseCms\Database\AbstractCollection;

final class AdminnewsletterController extends AbstractAdminController implements RepositoriesInterface
{
    public function onConstruct(): void
    {
        parent::onConstruct();

        $this->class = Newsletter::class;
        $this->classForm = NewsletterForm::class;
        $this->listOrder = 'createdAt';
        $this->listOrderDirection = -1;
        $this->listNestable = true;
        $this->listSortable = true;
        $this->parseAsJob = ['sendPreview'];
    }

    public function sendPreviewAction(string $id): void
    {
        if ($id && $this->request->get('previewEmail')) :
            $newsletter = $this->repositories->newsletter->getById($id, false);
            if ($newsletter !== null) :
                NewsletterQueueHelper::send(
                    NewsletterQueueFactory::create(
                        $this->request->get('previewEmail'),
                        '',
                        $id,
                        '',
                        $newsletter->getSubject(),
                        $newsletter->getBody() ?? ''
                    ),
                    $this->setting,
                    $this->view
                );

                $this->flash->setSucces('ADMIN_EMAIL_SEND_SUCCESS');
            else :
                $this->flash->setError('ADMIN_EMAIL_SEND_FAILED');
            endif;
        else :
            $this->flash->setError('ADMIN_EMAIL_SEND_FAILED');
        endif;

        parent::redirect();
    }

    public function queueNewsletterAction(string $id): void
    {
        $newsletter = $this->repositories->newsletter->getById($id);
        if ($newsletter !== null) :
            NewsletterHelper::queueMembers(
                $newsletter,
                $this->repositories
            );
            $this->flash->setSuccess('NEWSLETTER_ADDED_TO_QUEUE');
        else :
            $this->flash->setError('NEWSLETTER_NOT_FOUND');
        endif;

        parent::redirect();
    }

    public function afterSave(AbstractCollection $newsletter): void
    {
        if ($newsletter->getParentId() !== null) :
            $parentItem = $this->repositories->newsletter->getById($newsletter->getParentId(), false);
            if ($parentItem !== null) :
                $parentItem->setHasChildren(true);
                $parentItem->save();
            endif;
        endif;
    }
}
