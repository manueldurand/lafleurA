<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LafleurVilles
 *
 */
#[ORM\Table(name: 'lafleur_villes')]
#[ORM\Entity]
class LafleurVilles
{
    /**
     * @var int
     *
     */
    #[ORM\Column(name: 'id_ville', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $idVille;

    /**
     * @var string
     *
     */
    #[ORM\Column(name: 'ville', type: 'string', length: 45, nullable: false)]
    private $ville;

    public function getIdVille(): ?int
    {
        return $this->idVille;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }


}
