<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\OrderUser;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;
//methode de customisation de requepet non prioritaire sur un custom data provider !!!!
final class CurrentUserExtension implements QueryCollectionExtensionInterface, RestrictedDataProviderInterface
{
    private Security $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null): void {
        if (OrderUser::class == $resourceClass) {
            {
                $this->addWhere($queryBuilder, $resourceClass);
            }
        }
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void {
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere(sprintf('%s.customer = :current_user', $rootAlias));
        $queryBuilder->setParameter(':current_user', $this->security->getUser()->getId());
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool {
        dd($context);
    }
}
