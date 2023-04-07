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

    public function __construct()
    {
        parent::__construct();
        $this->setRoles([self::ROLES['Administrateur']]);
    }
}
