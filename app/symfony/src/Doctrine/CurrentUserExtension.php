<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\OrderSeller;
use App\Entity\OrderUser;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\ProductsRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

//methode de customisation de requepet non prioritaire sur un custom data provider !!!!
final class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface {
    private Security $security;

    public function __construct(Security $security, ProductsRepository $productsRepository) {
        $this->security = $security;
        $this->productsRepository = $productsRepository;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null): void {

        if ($operationName === "MANAGE") {
            switch ($resourceClass) {
                case Product::class :
                    $this->addWhereCurrentUser($queryBuilder, 'seller_id');
                    break;
            }
        }
        elseif ($operationName === 'api_order_users_products_orders_get_subresource') {
            $this->addWhereCurrentSeller($queryBuilder,);
        }
//        TODO à remplir
        switch ($resourceClass) {
            case OrderUser::class :
                $this->addWhereCurrentUser($queryBuilder, '');
                break;
            case OrderSeller::class :
                $this->addWhereCurrentUser($queryBuilder, '');
                break;
            case User::class:
                $this->addWhereCurrentUser($queryBuilder, '');
                break;
        }
    }

    private function addWhereCurrentUser(QueryBuilder $queryBuilder, $columName = 'customer'): void {

        if ($this->security->isGranted('ROLE_ADMIN') || null === $user = $this->security->getUser()) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere(sprintf('%s.%s = :current_user', $rootAlias, $columName));
        $queryBuilder->setParameter(':current_user', $user->getId());
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = []) {

    }

    private function addWhereCurrentSeller(QueryBuilder $queryBuilder,) {

        if (
//            $this->security->isGranted('ROLE_ADMIN')||
            null === $user = $this->security->getUser()
        ) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->innerJoin($rootAlias . '.product', 'product');
        $queryBuilder->andWhere(sprintf('%s.%s = :current_user', 'product', 'seller'));
        $queryBuilder->setParameter(':current_user', $user->getId());

    }
}
