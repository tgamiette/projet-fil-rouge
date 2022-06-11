<?php

namespace App\Events;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener {

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event) {
        $data = $event->getData();
        $user = $event->getUser();

        $data['data'] = array(
            'roles' => $user->getRoles(),
            'username' => $user->getUserIdentifier(),
            'id' => $user->getId(),
        );

//        dd($data,$user);

        $event->setData($data);
    }
}
