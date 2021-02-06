<?php declare(strict_types=1);

namespace VitesseCms\Communication\Controllers;

use VitesseCms\Communication\Forms\NewsletterListForm;
use VitesseCms\Communication\Forms\NewsletterListImportForm;
use VitesseCms\Communication\Helpers\ExportHelper;
use VitesseCms\Communication\Repositories\RepositoriesInterface;
use VitesseCms\Communication\Repositories\RepositoryInterface;
use VitesseCms\Communication\Models\NewsletterList;
use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Communication\Repositories\RepositoryCollection;
use VitesseCms\Datafield\Repositories\DatafieldRepository;
use VitesseCms\Datagroup\Repositories\DatagroupRepository;
use VitesseCms\Database\AbstractCollection;
use VitesseCms\Core\Utils\FileUtil;
use VitesseCms\Export\Repositories\ExportTypeRepository;
use VitesseCms\Export\Repositories\ItemRepository;
use VitesseCms\Language\Repositories\LanguageRepository;

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
        $exportHelper = new ExportHelper($this->configuration->getLanguage(), new \VitesseCms\Export\Repositories\RepositoryCollection(
            new ExportTypeRepository(),
            new ItemRepository(),
            new LanguageRepository(),
            new DatagroupRepository(),
            new DatafieldRepository()
        ));
        $exportHelper->setItems([$this->repositories->newsletterList->getById($newsletterListId)]);
        $exportHelper->setFields(['members', 'subscribed', 'GdprEmail']);
        $exportHelper->setHeaders();
        $exportHelper->createOutput();
        $this->view->disable();
    }

    public function parseImportFormAction(): void
    {
        if($this->request->get('newsletterlist') && $this->request->hasFiles()) :
            foreach ($this->request->getUploadedFiles() as $file) :
                $name = FileUtil::sanatize($file->getName());
                if ($file->moveTo($this->config->get('uploadDir') . $name)) :
                    if (($handle = fopen($this->config->get('uploadDir') . $name, 'rb')) !== false) :
                        $newsletterList = $this->repositories->newsletterList->getById($this->request->get('newsletterlist'));
                        while (($data = fgetcsv($handle, 1000, ',')) !== false) :
                            $newsletterList->addMember($data[0]);
                        endwhile;
                        $newsletterList->save();
                    endif;
                    $this->flash->setSucces('ADMIN_FILE_UPLOAD_SUCCESS', [$file->getName()]);
                else :
                    $this->flash->setError('ADMIN_FILE_UPLOAD_FAILED', [$file->getName()]);
                endif;
            endforeach;

            $this->redirect(
                $this->url->getBaseUri().
                'admin/communication/adminnewsletterlist/edit/'.
                $this->request->get('newsletterlist')
            );
        endif;

        $this->redirect();
    }

    public function deleteMemberAction(string $id, int $key): void
    {
        if($id && is_numeric($key)) :
            $newsletterList = $this->repositories->newsletterList->getById($id, false);
            $members = $newsletterList->getMembers();
            if(isset($members[$key])) :
                $newsletterList->removeMember($members[$key]['email'])->save();
            endif;
            $this->flash->setSucces('Member is removed');
        endif;

        $this->redirect();
    }

    public function unsubscribeMemberAction(string $id, int $key): void
    {
        if($id && is_numeric($key)) :
            $newsletterList = $this->repositories->newsletterList->getById($id, false);
            $members = $newsletterList->getMembers();
            if(isset($members[$key])) :
                $newsletterList = $newsletterList->unsubscribeMember($members[$key]['email']);
            endif;
            $newsletterList->save();
            $this->flash->setSucces('Member is unsubscribed');

        endif;

        $this->redirect();
    }

    public function subscribeMemberAction(string $id, int $key): void
    {
        if($id && is_numeric($key)) :
            $newsletterList = $this->repositories->newsletterList->getById($id, false);
            $members = $newsletterList->getMembers();
            if(isset($members[$key])) :
                $newsletterList = $newsletterList->subscribeMember($members[$key]['email']);
            endif;
            $newsletterList->save();
            $this->flash->setSucces('Member is subscribed');

        endif;

        $this->redirect();
    }
}
