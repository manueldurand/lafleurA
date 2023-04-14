<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * LafleurCategories
 *
 */
#[ORM\Table(name: 'lafleur_categories')]
#[ORM\Entity]
class LafleurCategories
{
    /**
     * @var int
     *
     */
    #[ORM\Column(name: 'id_categories', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $idCategories;

    /**
     * @var string
     *
     */
    #[ORM\Column(name: 'libelle', type: 'string', length: 45, nullable: false)]
    private $libelle;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     */
    #[ORM\ManyToMany(targetEntity: 'LafleurProduits', mappedBy: 'categories')]
    private $produit = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->produit = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdCategories(): ?int
    {
        return $this->idCategories;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
            $produit->addCategory($this);
        }

        return $this;
    }

    public function removeProduit(LafleurProduits $produit): self
    {
        if ($this->produit->removeElement($produit)) {
            $produit->removeCategory($this);
        }

        return $this;
    }

}
