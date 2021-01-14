<?php declare(strict_types=1);

namespace VitesseCms\Communication\Models;

use VitesseCms\Database\AbstractCollection;

class Email extends AbstractCollection
{
    /**
     * @var string
     */
    public $systemAction;

    /**
     * @var string
     */
    public $state;

    public function getAdminlistName(): string
    {
        return $this->_('subject');
    }

    public function getSubjectField(): string
    {
        return $this->_('subject');
    }

    public function getBodyField(): string
    {
        return $this->_('body');
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
