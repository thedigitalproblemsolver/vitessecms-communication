<?php declare(strict_types=1);

namespace VitesseCms\Communication\Models;

use VitesseCms\Database\AbstractCollection;

class Newsletter extends AbstractCollection
{
    /**
     * @var ?string
     */
    public $language;

    /**
     * @var ?string
     */
    public $template;

    /**
     * @var ?string
     */
    public $body;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var bool
     */
    public $hasChildren;

    /**
     * @var string
     */
    public $list;

    /**
     * @var string
     */
    public $emailType;

    /**
     * @var string
     */
    public $emailHeaderTargetPage;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $days;

    /**
     * @var string
     */
    public $sendTime;

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): Newsletter
    {
        $this->language = $language;

        return $this;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(?string $template): Newsletter
    {
        $this->template = $template;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): Newsletter
    {
        $this->body = $body;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): Newsletter
    {
        $this->subject = $subject;

        return $this;
    }

    public function setHasChildren(bool $value): Newsletter
    {
        $this->hasChildren = $value;

        return $this;
    }

    public function getList(): ?string
    {
        return $this->list;
    }

    public function setList(?string $list): Newsletter
    {
        $this->list = $list;

        return $this;
    }

    public function getEmailType(): ?string
    {
        return $this->emailType;
    }

    public function getEmailHeaderTargetPage(): ?string
    {
        return $this->emailHeaderTargetPage;
    }

    public function setName(string $name): Newsletter
    {
        $this->name = $name;

        return $this;
    }

    public function getDays(): ?float
    {
        return $this->days;
    }

    public function getSendTime(): ?string
    {
        return $this->sendTime;
    }
}
