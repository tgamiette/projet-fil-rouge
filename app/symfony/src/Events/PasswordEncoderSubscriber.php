<?php

namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordEncoderSubscriber implements EventSubscriberInterface {

    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder) {
        $this->encoder = $encoder;
    }

    /**
	 * @inheritDoc
	 */
	public static function getSubscribedEvents(): array {
        return [
            KernelEvents::VIEW =>['encodePassword', EventPriorities::PRE_WRITE]
        ];
	}

    public function encodePassword(ViewEvent $event) {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
//        dd($user,$method);
        if ($user instanceof  User && $method ==='POST'){
            $hash = $this->encoder->hashPassword($user,$user->getPassword());
            $user->setPassword($hash);

        }

    }
}
