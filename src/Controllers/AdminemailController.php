<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Controllers;

use ArrayIterator;
use stdClass;
use VitesseCms\Admin\Interfaces\AdminModelDeletableInterface;
use VitesseCms\Admin\Interfaces\AdminModelEditableInterface;
use VitesseCms\Admin\Interfaces\AdminModelFormInterface;
use VitesseCms\Admin\Interfaces\AdminModelListInterface;
use VitesseCms\Admin\Interfaces\AdminModelPublishableInterface;
use VitesseCms\Admin\Traits\TraitAdminModelDeletable;
use VitesseCms\Admin\Traits\TraitAdminModelEditable;
use VitesseCms\Admin\Traits\TraitAdminModelList;
use VitesseCms\Admin\Traits\TraitAdminModelPublishable;
use VitesseCms\Communication\Enums\EmailEnum;
use VitesseCms\Communication\Forms\EmailForm;
use VitesseCms\Communication\Models\Email;
use VitesseCms\Communication\Repositories\EmailRepository;
use VitesseCms\Core\AbstractControllerAdmin;
use VitesseCms\Database\AbstractCollection;
use VitesseCms\Database\Models\FindValueIterator;

final class AdminemailController extends AbstractControllerAdmin implements
    AdminModelListInterface,
    AdminModelPublishableInterface,
    AdminModelEditableInterface,
    AdminModelDeletableInterface
{
    use TraitAdminModelList;
    use TraitAdminModelPublishable;
    use TraitAdminModelEditable;
    use TraitAdminModelDeletable;

    protected array $parseAsJob = ['sendPreview'];

    private readonly EmailRepository $emailRepository;

    public function getModelList(?FindValueIterator $findValueIterator): ArrayIterator
    {
        return $this->emailRepository->findAll($findValueIterator, false);
    }


    public function onConstruct()
    {
        parent::onConstruct();

        $this->emailRepository = $this->eventsManager->fire(EmailEnum::GET_REPOSITORY->value, new stdClass());
    }

    public function sendPreviewAction(string $id): void
    {
        if ($this->user->getId()) :
            $email = $this->emailRepository->getById($id, false);
            $this->mailer->sendMail(
                $this->user->getEmail(),
                $email->getSubjectField(),
                $email->getBodyField()
            );
            $this->flashService->setSucces('Preview email is send to ' . $this->user->getEmail());
        endif;

        $this->redirect($this->request->getHTTPReferer());
    }

    public function getModelForm(): AdminModelFormInterface
    {
        return new EmailForm();
    }

    public function getModel(string $id): ?AbstractCollection
    {
        return match ($id) {
            'new' => new Email(),
            default => $this->emailRepository->getById($id, false)
        };
    }
}
