<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LafleurTypePlante
 *
 */
#[ORM\Table(name: 'lafleur_type_plante')]
#[ORM\Entity]
class LafleurTypePlante
{
    /**
     * @var int
     *
     */
    #[ORM\Column(name: 'id_type_plante', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $idTypePlante;

    /**
     * @var string
     *
     */
    #[ORM\Column(name: 'nom_plante', type: 'string', length: 45, nullable: false)]
    private $nomPlante;

    /**
     * @var string|null
     *
     */
    #[ORM\Column(name: 'description', type: 'string', length: 255, nullable: true)]
    private $description;

    public function getIdTypePlante(): ?int
    {
        return $this->idTypePlante;
    }

    public function getNomPlante(): ?string
    {
        return $this->nomPlante;
    }

    public function setNomPlante(string $nomPlante): self
    {
        $this->nomPlante = $nomPlante;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }


}
