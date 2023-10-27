<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Enums;

enum EmailEnum: string
{
    case LISTENER = 'EmailListener';
    case GET_REPOSITORY = 'EmailListener:getRepository';
}