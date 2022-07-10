<?php

namespace App\DataProvider;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryResultCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Product;
use App\Repository\ProductsRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

class GetSelfProductsOrderUserDataProvider implements RestrictedDataProviderInterface, ContextAwareCollectionDataProviderInterface {
    private iterable $collectionExtensions;
    private ProductsRepository $productsRepository;
    private Security $security;

    public function __construct(ProductsRepository $productsRepository, Security $security, iterable $itemExtensions) {
        $this->collectionExtensions = $itemExtensions;
        $this->productsRepository = $productsRepository;
        $this->security = $security;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable {
        $user = $this->security->getUser();
        $queryBuilder = $this->productsRepository->createQueryBuilder('o');
        $queryNameGenerator = new QueryNameGenerator();

        $this->addWhere($queryBuilder);

        foreach ($this->collectionExtensions as $extension) {
            $extension->applyToCollection($queryBuilder, $queryNameGenerator, $resourceClass, $operationName, $context);

//            Pagination
            if ($extension instanceof QueryResultCollectionExtensionInterface && $extension->supportsResult($resourceClass, $operationName, $context)) {
                return $extension->getResult($queryBuilder, $resourceClass, $operationName, $context);
            }
        }

        return $queryBuilder->getQuery()->getArrayResult();
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool {
        return $resourceClass == Product::class && $operationName == "MANAGE";
    }

    private function addWhere(QueryBuilder $queryBuilder): void {
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere(sprintf('%s.seller = :current_user', $rootAlias));
        $queryBuilder->setParameter(':current_user', $this->security->getUser()->getId());
    }
}
