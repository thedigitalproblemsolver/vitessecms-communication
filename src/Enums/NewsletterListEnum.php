<?php declare(strict_types=1);

namespace VitesseCms\Communication\Enums;

enum NewsletterListEnum: string
{
    case SERVICE_LISTENER = 'NewsletterListListener';
    case GET_REPOSITORY = 'NewsletterListListener:getRepository';
}