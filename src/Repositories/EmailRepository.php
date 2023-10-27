<?php

declare(strict_types=1);

namespace VitesseCms\Communication\Repositories;

use VitesseCms\Communication\Models\Email;
use VitesseCms\Communication\Models\EmailIterator;
use VitesseCms\Database\Models\FindOrderIterator;
use VitesseCms\Database\Models\FindValueIterator;
use VitesseCms\Database\Traits\TraitRepositoryConstructor;
use VitesseCms\Database\Traits\TraitRepositoryParseFindAll;
use VitesseCms\Database\Traits\TraitRepositoryParseGetById;

final class EmailRepository
{
    use TraitRepositoryConstructor;
    use TraitRepositoryParseGetById;
    use TraitRepositoryParseFindAll;

    public function getById(string $id, bool $hideUnpublished = true): ?Email
    {
        return $this->parseGetById($id, $hideUnpublished);
    }

    public function findAll(
        ?FindValueIterator $findValuesIterator = null,
        bool $hideUnpublished = true,
        ?int $limit = null,
        ?FindOrderIterator $findOrders = null,
        ?array $returnFields = null
    ): EmailIterator {
        return $this->parseFindAll($findValuesIterator, $hideUnpublished, $limit, $findOrders, $returnFields);
    }
}
