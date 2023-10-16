<?php declare(strict_types=1);

namespace VitesseCms\Communication\Enums;

enum NewsletterQueueEnum: string
{
    case SERVICE_LISTENER = 'NewsletterQueueListener';
    case GET_REPOSITORY = 'NewsletterQueueListener:getRepository';
}