<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LafleurAdresses
 *
 */
#[ORM\Table(name: 'lafleur_adresses')]
#[ORM\Index(name: 'fk_adresse_ville1_idx', columns: ['ville_id'])]
#[ORM\Index(name: 'fk_adresse_code_postal1_idx', columns: ['code_postal_id'])]
#[ORM\Entity]
class LafleurAdresses
{
    /**
     * @var int
     *
     */
    #[ORM\Column(name: 'id_adresse', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $idAdresse;

    /**
     * @var string
     *
     */
    #[ORM\Column(name: 'adresse', type: 'string', length: 255, nullable: false)]
    private $adresse;

    /**
     * @var string|null
     *
     */
    #[ORM\Column(name: 'complement_adresse', type: 'string', length: 255, nullable: true)]
    private $complementAdresse;

    /**
     * @var \LafleurCodePostal
     *
     */
    #[ORM\JoinColumn(name: 'code_postal_id', referencedColumnName: 'id_code_postal')]
    #[ORM\ManyToOne(targetEntity: 'LafleurCodePostal')]
    private $codePostal;

    /**
     * @var \LafleurVilles
     *
     */
    #[ORM\JoinColumn(name: 'ville_id', referencedColumnName: 'id_ville')]
    #[ORM\ManyToOne(targetEntity: 'LafleurVilles')]
    private $ville;

    public function getIdAdresse(): ?int
    {
        return $this->idAdresse;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getComplementAdresse(): ?string
    {
        return $this->complementAdresse;
    }

    public function setComplementAdresse(?string $complementAdresse): self
    {
        $this->complementAdresse = $complementAdresse;

        return $this;
    }

    public function getCodePostal(): ?LafleurCodePostal
    {
        return $this->codePostal;
    }

    public function setCodePostal(?LafleurCodePostal $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?LafleurVilles
    {
        return $this->ville;
    }

    public function setVille(?LafleurVilles $ville): self
    {
        $this->ville = $ville;

        return $this;
    }


}
