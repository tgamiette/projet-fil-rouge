<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TestVoter extends Voter {
    public const EDIT = 'TEST_EDIT';
    public const READ = 'TEST_READ';
    public const VIEW = 'TEST_VIEW';

    protected function supports(string $attribute, $subject): bool {
//        dd($subject);
        return in_array($attribute, [self::EDIT, self::VIEW, self::READ]);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                break;
            case self::VIEW:
                break;
            case self::READ:
                return true;
                break;
        }

        return false;
    }


    private function accessRead(UserInterface $user, $subject){

    }
}
