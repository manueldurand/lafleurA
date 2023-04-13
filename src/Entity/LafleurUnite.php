<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LafleurUnite
 *
 * @ORM\Table(name="lafleur_unite")
 * @ORM\Entity
 */
class LafleurUnite
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_unite", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUnite;

    /**
     * @var string
     *
     * @ORM\Column(name="type_unite", type="string", length=45, nullable=false)
     */
    private $typeUnite;

    public function getIdUnite(): ?int
    {
        return $this->idUnite;
    }

    public function getTypeUnite(): ?string
    {
        return $this->typeUnite;
    }

    public function setTypeUnite(string $typeUnite): self
    {
        $this->typeUnite = $typeUnite;

        return $this;
    }


}
