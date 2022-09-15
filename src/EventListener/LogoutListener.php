<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogoutListener
{
    private FlashBagInterface $flashBag;

    public function __construct(private RequestStack $requestStack)
    {

//        $this->flashBag = $requestStack->getSession()->set("success_logout", "Vous avez bien été déconnecté");
    }

    public function onSymfonyComponentSecurityHttpEventLogoutEvent(LogoutEvent $event): void
    {
        $this->requestStack->getSession()->set("success_logout", "Vous avez bien été déconnecté");
//        $this->flashBag->add('success', 'logout message');
        /*
        If you need user...
        if (($token = $event->getToken()) && $user = $token->getUser()) {
            $user available
        }
        */
    }
}