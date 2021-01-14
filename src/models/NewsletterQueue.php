<?php declare(strict_types=1);

namespace VitesseCms\Communication\Models;

use VitesseCms\Database\AbstractCollection;

class NewsletterQueue extends AbstractCollection
{
    /**
     * @var string
     */
    public $body;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var string
     */
    public $newsletterListId;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $dateOpened;

    /**
     * @var string
     */
    public $userId;

    /**
     * @var string
     */
    public $newsletterId;

    public function getBodyField(): string
    {
        return $this->_('body');
    }

    public function getNewsletterListId(): ?string
    {
        return $this->newsletterListId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDateOpened(): ?string
    {
        return $this->dateOpened;
    }

    public function setDateOpened($dateOpened): NewsletterQueue
    {
        $this->dateOpened = $dateOpened;

        return $this;
    }

    public function setBody(string $body): NewsletterQueue
    {
        $this->body = $body;

        return $this;
    }

    public function setSubject(string $subject): NewsletterQueue
    {
        $this->subject = $subject;

        return $this;
    }

    public function setNewsletterListId(string $newsletterListId): NewsletterQueue
    {
        $this->newsletterListId = $newsletterListId;

        return $this;
    }

    public function setEmail(string $email): NewsletterQueue
    {
        $this->email = $email;

        return $this;
    }

    public function setUserId(string $userId): NewsletterQueue
    {
        $this->userId = $userId;

        return $this;
    }

    public function setNewsletterId(string $newsletterId): NewsletterQueue
    {
        $this->newsletterId = $newsletterId;

        return $this;
    }
}