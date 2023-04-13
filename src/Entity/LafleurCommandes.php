<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * LafleurCommandes
 *
 * @ORM\Table(name="lafleur_commandes", indexes={@ORM\Index(name="fk_lafleur_commandes_lafleur_lots1_idx", columns={"lot_id"}), @ORM\Index(name="fk_commande_client1_idx", columns={"client_id"})})
 * @ORM\Entity
 */
class LafleurCommandes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_commande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_commande", type="datetime", nullable=false)
     */
    private $dateCommande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="livraison_souhaitee", type="datetime", nullable=false)
     */
    private $livraisonSouhaitee;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_livraison", type="datetime", nullable=true)
     */
    private $dateLivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_commande", type="string", length=45, nullable=false)
     */
    private $etatCommande;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="m_a_j", type="datetime", nullable=true)
     */
    private $mAJ;

    /**
     * @var \LafleurClients
     *
     * @ORM\ManyToOne(targetEntity="LafleurClients")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client_id", referencedColumnName="id_client")
     * })
     */
    private $client;

    /**
     * @var \LafleurLots
     *
     * @ORM\ManyToOne(targetEntity="LafleurLots")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lot_id", referencedColumnName="id_lot")
     * })
     */
    private $lot;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="LafleurProduits", inversedBy="commande")
     * @ORM\JoinTable(name="lafleur_commande_produits",
     *   joinColumns={
     *     @ORM\JoinColumn(name="commande_id", referencedColumnName="id_commande")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="produit_id", referencedColumnName="id_produit")
     *   }
     * )
     */
    private $produit = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->produit = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdCommande(): ?int
    {
        return $this->idCommande;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getLivraisonSouhaitee(): ?\DateTimeInterface
    {
        return $this->livraisonSouhaitee;
    }

    public function setLivraisonSouhaitee(\DateTimeInterface $livraisonSouhaitee): self
    {
        $this->livraisonSouhaitee = $livraisonSouhaitee;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->dateLivraison;
    }

    public function setDateLivraison(?\DateTimeInterface $dateLivraison): self
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    public function getEtatCommande(): ?string
    {
        return $this->etatCommande;
    }

    public function setEtatCommande(string $etatCommande): self
    {
        $this->etatCommande = $etatCommande;

        return $this;
    }

    public function getMAJ(): ?\DateTimeInterface
    {
        return $this->mAJ;
    }

    public function setMAJ(?\DateTimeInterface $mAJ): self
    {
        $this->mAJ = $mAJ;

        return $this;
    }

    public function getClient(): ?LafleurClients
    {
        return $this->client;
    }

    public function setClient(?LafleurClients $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getLot(): ?LafleurLots
    {
        return $this->lot;
    }

    public function setLot(?LafleurLots $lot): self
    {
        $this->lot = $lot;

        return $this;
    }

    /**
     * @return Collection<int, LafleurProduits>
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(LafleurProduits $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit->add($produit);
        }

        return $this;
    }

    public function removeProduit(LafleurProduits $produit): self
    {
        $this->produit->removeElement($produit);

        return $this;
    }

}
