<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LafleurLots
 *
 * @ORM\Table(name="lafleur_lots")
 * @ORM\Entity
 */
class LafleurLots
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_lot", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLot;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_lot", type="string", length=45, nullable=false)
     */
    private $nomLot;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;

    public function getIdLot(): ?int
    {
        return $this->idLot;
    }

    public function getNomLot(): ?string
    {
        return $this->nomLot;
    }

    public function setNomLot(string $nomLot): self
    {
        $this->nomLot = $nomLot;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }


}
