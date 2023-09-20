<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Listeners\Models;

use ArrayIterator;
use Phalcon\Events\Event;
use VitesseCms\Communication\Models\NewsletterListIterator;
use VitesseCms\Communication\Repositories\NewsletterListRepository;
use VitesseCms\Communication\Repositories\NewsletterQueueRepository;
use VitesseCms\Database\Models\FindValue;
use VitesseCms\Database\Models\FindValueIterator;
use VitesseCms\Log\Services\LogService;
use VitesseCms\User\Models\User;

class UserListener
{
    public function __construct(
        private readonly LogService $logService,
        private readonly NewsletterListRepository $newsletterListRepository,
        private readonly NewsletterQueueRepository $newsletterQueueRepository
    ) {
    }

    public function beforeDelete(Event $event, User $user): bool
    {
        $this->removeMemberFromNewsletterLists(
            $this->newsletterListRepository->findAll(
                new FindValueIterator([new FindValue('members.email', $user->getString('email'))]),
                false
            ),
            $user->getString('email')
        );

        $this->performDeletion(
            $this->newsletterQueueRepository->findAll(
                new FindValueIterator([new FindValue('userId', (string)$user->getId())]),
                false
            ),
            'NewsletterQueue',
            'NewsletterQueues'
        );

        return true;
    }

    private function removeMemberFromNewsletterLists(
        NewsletterListIterator $newsletterListIterator,
        string $email
    ): void {
        if ($newsletterListIterator->count() > 0) {
            while ($newsletterListIterator->valid()) {
                $newsletterListIterator->current()->removeMember($email)->save();
                $this->logService->message('Removed member from NewsletterList');

                $newsletterListIterator->next();
            }
        } else {
            $this->logService->message('No NewsletterLists found to remove member');
        }
    }

    private function performDeletion(ArrayIterator $models, string $type, string $types): void
    {
        if ($models->count() > 0) {
            $this->logService->message('Start deleting ' . $types);
            while ($models->valid()) {
                if ($models->current()->delete()) {
                    $this->logService->message('Deleted a ' . $type);
                } else {
                    $this->logService->message('Failed to delete a ' . $type);
                }

                $models->next();
            }
            $this->logService->message('Finished deleting ' . $types);
        } else {
            $this->logService->message('No ' . $types . ' found to delete');
        }
    }
}