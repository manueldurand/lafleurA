<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LafleurCodePostal
 *
 * @ORM\Table(name="lafleur_code_postal")
 * @ORM\Entity
 */
class LafleurCodePostal
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_code_postal", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCodePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=5, nullable=false, options={"fixed"=true})
     */
    private $codePostal;

    public function getIdCodePostal(): ?int
    {
        return $this->idCodePostal;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }


}
