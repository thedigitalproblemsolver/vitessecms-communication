<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Listeners\Models;

use VitesseCms\Communication\Repositories\EmailRepository;
use VitesseCms\Database\Traits\TraitRepositoryListener;

final class EmailListener
{
    use TraitRepositoryListener;

    public function __construct(private readonly string $class)
    {
        $this->setRepositoryClass($class);
    }

    public function getRepository(): EmailRepository
    {
        return $this->parseGetRepository();
    }
}