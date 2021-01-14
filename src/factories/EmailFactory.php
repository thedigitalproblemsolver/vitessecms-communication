<?php declare(strict_types=1);

namespace VitesseCms\Communication\Factories;

use VitesseCms\Communication\Models\Email;

class EmailFactory
{
    public static function create(
        string $subject,
        string $body,
        string $systemAction,
        string $triggerState,
        bool $published = false,
        string $alternativeRecipient = null,
        string $messageSuccess = null,
        string $messageError = null
    ): Email
    {
        $email = new Email();
        $email->set('subject', $subject, true)
            ->set('body', $body, true)
            ->setSystemAction($systemAction)
            ->setState($triggerState)
            ->setPublished($published)
            ->set('recipient', $alternativeRecipient, true)
            ->set('messageSuccess', $messageSuccess, true)
            ->set('messageError', $messageError, true);

        return $email;
    }
}
