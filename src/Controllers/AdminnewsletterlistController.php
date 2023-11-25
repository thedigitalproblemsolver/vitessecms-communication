<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Controllers;

use stdClass;
use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Communication\Forms\NewsletterListForm;
use VitesseCms\Communication\Forms\NewsletterListImportForm;
use VitesseCms\Communication\Helpers\ExportHelper;
use VitesseCms\Communication\Models\NewsletterList;
use VitesseCms\Communication\Repositories\RepositoriesInterface;
use VitesseCms\Content\Enum\ItemEnum;
use VitesseCms\Core\Utils\FileUtil;
use VitesseCms\Datafield\Enum\DatafieldEnum;
use VitesseCms\Datagroup\Enums\DatagroupEnum;
use VitesseCms\Export\Enums\ExportTypeEnums;
use VitesseCms\Export\Repositories\RepositoryCollection;
use VitesseCms\Language\Enums\LanguageEnum;

class AdminnewsletterlistController extends AbstractAdminController implements RepositoriesInterface
{
    public function onConstruct()
    {
        parent::onConstruct();

        $this->class = NewsletterList::class;
        $this->classForm = NewsletterListForm::class;
    }

    public function importFormAction(string $newsletterListId): void
    {
        $form = new NewsletterListImportForm();
        $form->setEntity($this->repositories->newsletterList->getById($newsletterListId));
        $form->setRepositories($this->repositories);
        $form->buildForm();
        $this->view->setVar(
            'content',
            $form->renderForm('admin/communication/adminnewsletterlist/parseimportform/')
        );

        $this->prepareView();
    }

    public function exportAction(string $newsletterListId): void
    {
        $exportHelper = new ExportHelper(
            $this->configuration->getLanguage(), new RepositoryCollection(
                $this->eventsManager->fire(ExportTypeEnums::GET_REPOSITORY->value, new stdClass()),
                $this->eventsManager->fire(ItemEnum::GET_REPOSITORY, new stdClass()),
                $this->eventsManager->fire(LanguageEnum::GET_REPOSITORY->value, new stdClass()),
                $this->eventsManager->fire(DatagroupEnum::GET_REPOSITORY->value, new stdClass()),
                $this->eventsManager->fire(DatafieldEnum::GET_REPOSITORY->value, new stdClass())
            )
        );
        $exportHelper->setItems([$this->repositories->newsletterList->getById($newsletterListId)]);
        $exportHelper->setFields(['members', 'subscribed', 'GdprEmail']);
        $exportHelper->setHeaders();
        $exportHelper->createOutput();
        $this->view->disable();
    }

    public function parseImportFormAction(): void
    {
        if ($this->request->get('newsletterlist') && $this->request->hasFiles()) {
            foreach ($this->request->getUploadedFiles() as $file) {
                $name = FileUtil::sanatize($file->getName());
                if ($file->moveTo($this->config->get('uploadDir') . $name)) {
                    if (($handle = fopen($this->config->get('uploadDir') . $name, 'rb')) !== false) {
                        $newsletterList = $this->repositories->newsletterList->getById(
                            $this->request->get('newsletterlist')
                        );
                        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                            $newsletterList->addMember($data[0]);
                        }
                        $newsletterList->save();
                    }
                    $this->flash->setSucces('ADMIN_FILE_UPLOAD_SUCCESS', [$file->getName()]);
                } else {
                    $this->flash->setError('ADMIN_FILE_UPLOAD_FAILED', [$file->getName()]);
                }
            }

            $this->redirect(
                $this->url->getBaseUri() .
                'admin/communication/adminnewsletterlist/edit/' .
                $this->request->get('newsletterlist')
            );
        }

        $this->redirect();
    }

    public function deleteMemberAction(string $id, int $key): void
    {
        if (!empty($id)) {
            $newsletterList = $this->repositories->newsletterList->getById($id, false);
            $members = $newsletterList->getMembers();
            if (isset($members[$key])) {
                $newsletterList->removeMember($members[$key]['email'])->save();
            }
            $this->flash->setSucces('Member is removed');
        }

        $this->redirect();
    }

    public function unsubscribeMemberAction(string $id, int $key): void
    {
        if (!empty($id)) {
            $newsletterList = $this->repositories->newsletterList->getById($id, false);
            $members = $newsletterList->getMembers();
            if (isset($members[$key])) {
                $newsletterList = $newsletterList->unsubscribeMember($members[$key]['email']);
            }
            $newsletterList->save();
            $this->flash->setSucces('Member is unsubscribed');
        }

        $this->redirect();
    }

    public function subscribeMemberAction(string $id, int $key): void
    {
        if (!empty($id)) {
            $newsletterList = $this->repositories->newsletterList->getById($id, false);
            $members = $newsletterList->getMembers();
            if (isset($members[$key])) {
                $newsletterList = $newsletterList->subscribeMember($members[$key]['email']);
            }
            $newsletterList->save();
            $this->flash->setSucces('Member is subscribed');
        }

        $this->redirect();
    }
}
