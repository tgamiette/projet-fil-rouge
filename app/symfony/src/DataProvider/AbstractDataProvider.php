<?php

namespace App\DataProvider;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\FilterExtension;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryResultCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use Doctrine\ORM\QueryBuilder;

class AbstractDataProvider {
    public const EQUAL = '=';

//    public function add(QueryBuilder $queryBuilder,, array $filters): void {
//
//        foreach ($filters as $filter => $value) {
//            $operation = substr($filter, strpos($filter, '|'), strpos($filter, '|', 1) - strpos($filter, '|'));
//            $colum = substr($filter,strpos($filter, '|',1));
//            $queryBuilder->andWhere(sprintf('%s.%s %s :current_user', $rootAlias,$colum,$operation));
//
//        }
//        $rootAlias = $queryBuilder->getRootAliases()[0];
//        $queryBuilder->setParameter(':current_user', $this->security->getUser()->getId());
//    }
}
