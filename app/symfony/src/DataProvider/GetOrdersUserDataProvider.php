<?php

namespace App\DataProvider;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryResultCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\OrderUser;
use App\Repository\OrderUserRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

class GetOrdersUserDataProvider implements RestrictedDataProviderInterface, ContextAwareCollectionDataProviderInterface {
    private iterable $collectionExtensions;
    private OrderUserRepository $orderUserRepository;
    private Security $security;

    public function __construct(OrderUserRepository $orderUserRepository, Security $security, iterable $itemExtensions) {
        $this->collectionExtensions = $itemExtensions;
        $this->orderUserRepository = $orderUserRepository;
        $this->security = $security;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable {
        $user = $this->security->getUser();
        $queryBuilder = $this->orderUserRepository->createQueryBuilder('o');
        $queryNameGenerator = new QueryNameGenerator();

        $this->addWhere($queryBuilder);

        foreach ($this->collectionExtensions as $extension) {
            $extension->applyToCollection($queryBuilder, $queryNameGenerator, $resourceClass, $operationName, $context);
//           Pagination
            if ($extension instanceof QueryResultCollectionExtensionInterface && $extension->supportsResult($resourceClass, $operationName, $context)) {
                return $extension->getResult($queryBuilder, $resourceClass, $operationName, $context);
            }
        }

        return $queryBuilder->getQuery()->getArrayResult();
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool {

        return $resourceClass == OrderUser::class && $operationName == "GET";
    }

    private function addWhere(QueryBuilder $queryBuilder): void {
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere(sprintf('%s.seller = :current_user', $rootAlias));
        $queryBuilder->setParameter(':current_user', $this->security->getUser()->getId());
    }
}
