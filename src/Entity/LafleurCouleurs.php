<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LafleurCouleurs
 *
 * @ORM\Table(name="lafleur_couleurs")
 * @ORM\Entity
 */
class LafleurCouleurs
{
    /**
     * @var int
     *
     * @ORM\Column(name="idcouleur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcouleur;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_couleur", type="string", length=45, nullable=false)
     */
    private $nomCouleur;

    public function getIdcouleur(): ?int
    {
        return $this->idcouleur;
    }

    public function getNomCouleur(): ?string
    {
        return $this->nomCouleur;
    }

    public function setNomCouleur(string $nomCouleur): self
    {
        $this->nomCouleur = $nomCouleur;

        return $this;
    }


}
