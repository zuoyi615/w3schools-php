<?php

namespace App\Filters;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class UserFilter extends SQLFilter
{

    public function addFilterConstraint(ClassMetadata $targetEntity, string $targetTableAlias): string
    {
        return $targetTableAlias.'.user_id='.$this->getParameter('user_id');
    }

}
