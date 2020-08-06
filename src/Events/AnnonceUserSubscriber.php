<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Annonce;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class AnnonceUserSubscriber implements EventSubscriberInterface {

    /** @var UserPasswordEncoderInterface */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW =>['encodePassword', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function encodePassword(ViewEvent $event) {
        $annonce = $event->getControllerResult();

        $method = $event->getRequest()->getMethod();

        if($annonce instanceof Annonce && $method === "POST") {
            $user = $this->security->getUser();

            $annonce->setUser($user);
        }
    }
}