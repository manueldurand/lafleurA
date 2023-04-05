<?php

namespace App\Entity\User;

use App\Entity\User as AbstractUser;
use App\Repository\User\MemberRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member extends AbstractUser
{
    const ROLES = [
        'Utilisateur' => 'ROLE_USER',
    ];

    #[Assert\NotBlank(groups: ['CreatePlainPassword'])]
    #[Assert\Regex(pattern: '/^(?=.*[^a-z0-9])(?=.*[0-9])(?=.*[a-z]).{8,}$/i', message:'Votre mot de passe doit contenir au moins 8 caractères, 1 chiffre, 1 lettre et 1 caractère spécial', groups: ['CreatePlainPassword', 'EditPlainPassword'])]
    // https://regex101.com/r/PxnGfh/1
    private ?string $plainPassword = null;

    public function __construct()
    {
        parent::__construct();
        $this->setRoles([self::ROLES['Utilisateur']]);
    }
}
