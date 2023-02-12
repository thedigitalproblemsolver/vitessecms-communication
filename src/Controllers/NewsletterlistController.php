<?php declare(strict_types=1);

namespace VitesseCms\Communication\Controllers;

use VitesseCms\Communication\Enums\NewsletterListEnum;
use VitesseCms\Communication\Enums\TranslationEnum;
use VitesseCms\Communication\Repositories\NewsletterListRepository;
use VitesseCms\Communication\Repositories\RepositoriesInterface;
use VitesseCms\Core\AbstractController;
use VitesseCms\Core\AbstractControllerFrontend;
use VitesseCms\Form\Controllers\IndexController;
use VitesseCms\Form\Utils\FormUtil;
use stdClass;

class NewsletterlistController extends AbstractControllerFrontend
{
    private NewsletterListRepository $newsletterListRepository;

    public function onConstruct()
    {
        parent::onConstruct();

        $this->newsletterListRepository = $this->eventsManager->fire(NewsletterListEnum::GET_REPOSITORY->value, new stdClass());
    }

    public function unsubscribeAction(string $newsletterListId): void
    {
        if ($this->activeUser->isLoggedIn()) :
            $newsletterList = $this->newsletterListRepository->getById($newsletterListId);
            if ($newsletterList !== null):
                $newsletterList->unsubscribeMember($this->activeUser->getEmail())->save();
                $this->flashService->setSucces(
                    TranslationEnum::COMMUNICATION_UNSUBSCRIBE_SUCCESS->name,
                    [$newsletterList->getNameField()]
                );
            endif;
        endif;

        $this->redirect($this->request->getServer('HTTP_REFERER'));
    }

    public function subscribeAction(string $newsletterListId): void
    {
        if ($this->activeUser->isLoggedIn()) :
            $newsletterList = $this->newsletterListRepository->getById($newsletterListId);
            if ($newsletterList !== null) :
                $newsletterList->subscribeMember($this->activeUser->getEmail())->save();
                $this->flashService->setSucces(
                    TranslationEnum::COMMUNICATION_SUBSCRIBE_SUCCESS->name,
                    [$newsletterList->getNameField()]
                );
            endif;
        endif;

        $this->redirect($this->request->getServer('HTTP_REFERER'));
    }
}
