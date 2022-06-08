<?php

namespace App\Events;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AuthenticationSuccessListener {

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event) {
        $data = $event->getData();
        $user = $event->getUser();
        KernelEvents::

//KernelEvents
//        if (!$user instanceof UserInterface) {
//            return;
//        }

        $data['data'] = array(
            'roles' => $user->getRoles(),
            'username' => $user->getUserIdentifier(),
            'id' => $user->getId(),
        );

//        dd($data,$user);

        $event->setData($data);
    }
}
