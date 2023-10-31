<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Listeners\Services;

use VitesseCms\Communication\Services\MailerService;

final class MailerServiceListener
{
    public function __construct(private readonly MailerService $mailerService)
    {
    }

    public function attach(): MailerService
    {
        return $this->mailerService;
    }
}