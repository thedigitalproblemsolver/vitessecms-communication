<?php declare(strict_types=1);

namespace VitesseCms\Communication\Repositories;

use VitesseCms\Communication\Models\Email;

class EmailRepository
{
    public function getById(string $id, bool $hideUnpublished = true): ?Email
    {
        Email::setFindPublished($hideUnpublished);

        /** @var Email $email */
        $email = Email::findById($id);
        if (is_object($email)):
            return $email;
        endif;

        return null;
    }
}
