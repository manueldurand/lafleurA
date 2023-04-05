<?php

namespace App\Entity\User;

use App\Entity\User as AbstractUser;
use App\Repository\User\MemberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member extends AbstractUser
{
    const ROLES = [
        'Utilisateur' => 'ROLE_USER',
    ];
    public function __construct()
    {
        parent::__construct();
        $this->setRoles([self::ROLES['Utilisateur']]);
    }
}
