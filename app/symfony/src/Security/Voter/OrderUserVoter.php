<?php

namespace App\Security\Voter;

use App\Entity\OrderUser;
use App\Entity\ProductsOrder;
use App\Entity\User;
use App\Repository\OrderUserRepository;
use App\Repository\ProductsOrderRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class OrderUserVoter extends Voter {
    public const PICKUP = 'ORDER_USER_PICKUP';
    public const CHECK = 'ORDER_USER_CHECK';

    public function __construct(private readonly Security $security, private ProductsOrderRepository $productsOrderRepository) {
    }

    protected function supports(string $attribute, $subject): bool {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::PICKUP, self::CHECK])
            && $subject instanceof \App\Entity\OrderUser;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface
//            && !$this->security->isGranted('ROLE_SELLER')
        ) {
            return false;
        }

        if ($this->security->isGranted("ROLE_ADMIN")) {
            return true;
        }
        return match ($attribute) {
            self::PICKUP => self::canPickup($subject, $user),
            self::CHECK => self::canCheck($subject, $user),
            default => false
        };
    }

    private function canPickup(OrderUser $subject, UserInterface $user): bool {
        $query = $this->productsOrderRepository->findProductsPickUp($user, $subject);
        //TODO mettre la négation
        return empty($query);
    }

    private function canCheck(OrderUser $subject, UserInterface $user): bool {
        $query = $this->productsOrderRepository->findProductsPickUp($user, $subject);
        //TODO mettre la négation
        return empty($query);
    }
}
