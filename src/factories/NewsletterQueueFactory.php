<?php declare(strict_types=1);

namespace VitesseCms\Communication\Factories;

use VitesseCms\Communication\Models\NewsletterQueue;
use DateTime;

class NewsletterQueueFactory
{
    public static function create(
        string $email,
        string $userId,
        string $newsletterId,
        string $newsletterListId,
        string $subject,
        string $body
    ): NewsletterQueue
    {
        return (new NewsletterQueue())
            ->setEmail($email)
            ->setUserId($userId)
            ->setNewsletterId($newsletterId)
            ->setNewsletterListId($newsletterListId)
            ->setSubject($subject)
            ->setBody($body);
    }
}
