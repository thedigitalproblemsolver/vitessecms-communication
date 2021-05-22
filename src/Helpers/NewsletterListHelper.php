<?php declare(strict_types=1);

namespace VitesseCms\Communication\Helpers;

use VitesseCms\Communication\Models\NewsletterList;
use VitesseCms\Database\AbstractCollection;

class NewsletterListHelper
{
    public static function emailExistsAsMember(string $email, NewsletterList $newsletterList): bool
    {
        foreach ($newsletterList->getMembers() as $member):
            if (isset($member['email']) && $member['email'] === $email) :
                return true;
            endif;
        endforeach;

        return false;
    }
}
