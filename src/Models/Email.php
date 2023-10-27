<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Models;

use VitesseCms\Database\AbstractCollection;

final class Email extends AbstractCollection
{
    public string $systemAction;
    public string $state;

    public function getNameField(?string $languageShort = null): string
    {
        return $this->getString('subject');
    }

    public function getSubjectField(): string
    {
        return $this->getString('subject');
    }

    public function getBodyField(): string
    {
        return $this->getString('body');
    }

    public function setSystemAction(string $systemAction): Email
    {
        $this->systemAction = $systemAction;

        return $this;
    }

    public function setState(string $state): Email
    {
        $this->state = $state;

        return $this;
    }
}
