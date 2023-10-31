<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Enums;

enum MailerEnum: string
{
    case ATTACH_SERVICE_LISTENER = 'MailerService:attach';
    case SERVICE_LISTENER = 'MailerService';
}