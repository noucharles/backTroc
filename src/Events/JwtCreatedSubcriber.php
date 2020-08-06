<?php

namespace App\Events;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtCreatedSubcriber {

    public function updateJwtData(JWTCreatedEvent $event)
    {
        //Recuperer l'utilisateur
        $user = $event->getUser();

        $data = $event->getData();
        $data['exp'] = 2000000000;
        $data['id'] = $user->getId();
        $data['name'] = $user->getName();

        $event->setData($data);
    }
}