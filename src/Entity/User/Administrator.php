<?php

namespace App\Entity\User;

use App\Entity\User;
use App\Repository\User\AdministratorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AdministratorRepository::class)]
class Administrator extends User
{
    const ROLES = [
        'Super Admin'    => 'ROLE_SUPER_ADMIN',
        'Administrateur' => 'ROLE_ADMIN',
    ];

    #[Assert\NotBlank(groups: ['CreatePlainPassword'])]
    #[Assert\Regex(pattern: '/^(?=.*[^a-z0-9])(?=.*[0-9])(?=.*[a-z]).{8,}$/i', message:'Votre mot de passe doit contenir au moins 8 caractères, 1 chiffre, 1 lettre et 1 caractère spécial', groups: ['CreatePlainPassword', 'EditPlainPassword'])]
    // https://regex101.com/r/PxnGfh/1
    private ?string $plainPassword = null;

    public function __construct()
    {
        parent::__construct();
        $this->setRoles([self::ROLES['Administrateur']]);
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
