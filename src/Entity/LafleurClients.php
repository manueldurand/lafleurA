<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LafleurClients
 *
 */
#[ORM\Table(name: 'lafleur_clients')]
#[ORM\Index(name: 'fk_lafleur_clients_lafleur_adresses1_id', columns: ['lafleur_adresses_id'])]
#[ORM\UniqueConstraint(name: 'emailClient_UNIQUE', columns: ['email_client'])]
#[ORM\Entity]
class LafleurClients
{
    /**
     * @var int
     *
     */
    #[ORM\Column(name: 'id_client', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $idClient;

    /**
     * @var string
     *
     */
    #[ORM\Column(name: 'nom_client', type: 'string', length: 45, nullable: false)]
    private $nomClient;

    /**
     * @var string
     *
     */
    #[ORM\Column(name: 'prenom_client', type: 'string', length: 45, nullable: false)]
    private $prenomClient;

    /**
     * @var string
     *
     */
    #[ORM\Column(name: 'email_client', type: 'string', length: 64, nullable: false)]
    private $emailClient;

    /**
     * @var string
     *
     */
    #[ORM\Column(name: 'mot_de_passe', type: 'string', length: 70, nullable: false)]
    private $motDePasse;

    /**
     * @var string
     *
     */
    #[ORM\Column(name: 'telephone', type: 'string', length: 15, nullable: false)]
    private $telephone;

    /**
     * @var \LafleurAdresses
     *
     */
    #[ORM\JoinColumn(name: 'lafleur_adresses_id', referencedColumnName: 'id_adresse')]
    #[ORM\ManyToOne(targetEntity: 'LafleurAdresses')]
    private $lafleurAdresses;

    public function getIdClient(): ?int
    {
        return $this->idClient;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): self
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getPrenomClient(): ?string
    {
        return $this->prenomClient;
    }

    public function setPrenomClient(string $prenomClient): self
    {
        $this->prenomClient = $prenomClient;

        return $this;
    }

    public function getEmailClient(): ?string
    {
        return $this->emailClient;
    }

    public function setEmailClient(string $emailClient): self
    {
        $this->emailClient = $emailClient;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getLafleurAdresses(): ?LafleurAdresses
    {
        return $this->lafleurAdresses;
    }

    public function setLafleurAdresses(?LafleurAdresses $lafleurAdresses): self
    {
        $this->lafleurAdresses = $lafleurAdresses;

        return $this;
    }


}
