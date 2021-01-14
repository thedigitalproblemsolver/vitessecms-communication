<?php declare(strict_types=1);

namespace VitesseCms\Communication\Controllers;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Communication\Forms\EmailForm;
use VitesseCms\Communication\Repositories\RepositoriesInterface;
use VitesseCms\Communication\Repositories\RepositoryInterface;
use VitesseCms\Communication\Models\Email;

class AdminemailController extends AbstractAdminController implements RepositoriesInterface
{
    /**
     * @var array
     */
    protected $parseAsJob = ['sendPreview'];

    public function onConstruct()
    {
        parent::onConstruct();

        $this->class = Email::class;
        $this->classForm = EmailForm::class;
        $this->listOrder = 'subject';
        $this->listTemplate = 'listNewsletterQueue';
        $this->listTemplatePath = $this->configuration->getVendorNameDir() . 'communication/src/resources/views/admin/';
    }

    public function sendPreviewAction(string $id): void
    {
        if($this->user->getId()) :
            $email = $this->repositories->email->getById($id);
            $this->mailer->sendMail(
                $this->user->getEmail(),
                $email->getSubjectField(),
                $email->getBodyField()
            );
            $this->flash->setSucces('Preview email is send to '. $this->user->_('email'));
        endif;

        $this->redirect();
    }
}
