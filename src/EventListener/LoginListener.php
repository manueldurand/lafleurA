<?php

namespace App\EventListener;

use App\Repository\UserRepository;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use App\Entity\User;

class LoginListener
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        // Get the User entity.
        /** @var User $user */
        $user = $event->getAuthenticationToken()->getUser();

        // Update login date
        $user->setLastLoggedAt(new \DateTimeImmutable());

        // Persist the data to database.
        $this->userRepository->save($user, true);
    }
}