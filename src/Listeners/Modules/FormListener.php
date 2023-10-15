<?php declare(strict_types=1);

namespace VitesseCms\Communication\Listeners\Modules;

use Phalcon\Events\Event;
use VitesseCms\Communication\Helpers\NewsletterHelper;
use VitesseCms\Communication\Repositories\NewsletterRepository;
use VitesseCms\Form\Blocks\FormBuilder;
use VitesseCms\Form\DTO\AfterSubmitDTO;

class FormListener
{
    public function __construct(private readonly NewsletterRepository $newsletterRepository){}

    public function afterSubmit(Event $event, AfterSubmitDTO $afterSubmitDTO)
    {
        $newsletters = $afterSubmitDTO->formBuilder->getNewsletters();
        foreach ($newsletters as $newsletterId) :
            $newsletter = $this->newsletterRepository->getById($newsletterId);
            if ($newsletter !== null) :
                NewsletterHelper::addMemberByEmail($newsletter, $afterSubmitDTO->submission->getEmail());
            endif;
        endforeach;
    }
}