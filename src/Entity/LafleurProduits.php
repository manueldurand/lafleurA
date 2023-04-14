<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * LafleurProduits
 *
 */
#[ORM\Table(name: 'lafleur_produits')]
#[ORM\Index(name: 'fk_lafleur_produits_unite1_id', columns: ['unite_id'])]
#[ORM\Index(name: 'fk_produit_couleur_id', columns: ['couleur_id'])]
#[ORM\Index(name: 'fk_lafleur_produits_type_plante1_id', columns: ['plante_id'])]
#[ORM\Entity]
class LafleurProduits
{
    /**
     * @var int
     *
     */
    #[ORM\Column(name: 'id_produit', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $idProduit;

    /**
     * @var string
     *
     */
    #[ORM\Column(name: 'prix', type: 'decimal', precision: 5, scale: 2, nullable: false)]
    private $prix;

    /**
     * @var string
     *
     */
    #[ORM\Column(name: 'description', type: 'string', length: 255, nullable: false)]
    private $description;

    /**
     * @var string
     *
     */
    #[ORM\Column(name: 'image1', type: 'string', length: 45, nullable: false)]
    private $image1;

    /**
     * @var string
     *
     */
    #[ORM\Column(name: 'image2', type: 'string', length: 45, nullable: false)]
    private $image2;

    /**
     * @var int
     *
     */
    #[ORM\Column(name: 'stock', type: 'integer', nullable: false)]
    private $stock;

    /**
     * @var \DateTime
     *
     */
    #[ORM\Column(name: 'date_m_a_j', type: 'datetime', nullable: false)]
    private $dateMAJ;

    /**
     * @var \LafleurUnite
     *
     */
    #[ORM\JoinColumn(name: 'unite_id', referencedColumnName: 'id_unite')]
    #[ORM\ManyToOne(targetEntity: 'LafleurUnite')]
    private $unite;

    /**
     * @var \LafleurCouleurs
     *
     */
    #[ORM\JoinColumn(name: 'couleur_id', referencedColumnName: 'idcouleur')]
    #[ORM\ManyToOne(targetEntity: 'LafleurCouleurs')]
    private $couleur;

    /**
     * @var \LafleurTypePlante
     *
     */
    #[ORM\JoinColumn(name: 'plante_id', referencedColumnName: 'id_type_plante')]
    #[ORM\ManyToOne(targetEntity: 'LafleurTypePlante')]
    private $plante;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     */
    #[ORM\ManyToMany(targetEntity: 'LafleurCommandes', mappedBy: 'produit')]
    private $commande = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     */
    #[ORM\JoinTable(name: 'lafleur_produits_categories')]
    #[ORM\JoinColumn(name: 'produit_id', referencedColumnName: 'id_produit')]
    #[ORM\InverseJoinColumn(name: 'categories_id', referencedColumnName: 'id_categories')]
    #[ORM\ManyToMany(targetEntity: 'LafleurCategories', inversedBy: 'produit')]
    private $categories = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commande = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdProduit(): ?int
    {
        return $this->idProduit;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage1(): ?string
    {
        return $this->image1;
    }

    public function setImage1(string $image1): self
    {
        $this->image1 = $image1;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image2;
    }

    public function setImage2(string $image2): self
    {
        $this->image2 = $image2;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getDateMAJ(): ?\DateTimeInterface
    {
        return $this->dateMAJ;
    }

    public function setDateMAJ(\DateTimeInterface $dateMAJ): self
    {
        $this->dateMAJ = $dateMAJ;

        return $this;
    }

    public function getUnite(): ?LafleurUnite
    {
        return $this->unite;
    }

    public function setUnite(?LafleurUnite $unite): self
    {
        $this->unite = $unite;

        return $this;
    }

    public function getCouleur(): ?LafleurCouleurs
    {
        return $this->couleur;
    }

    public function setCouleur(?LafleurCouleurs $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getPlante(): ?LafleurTypePlante
    {
        return $this->plante;
    }

    public function setPlante(?LafleurTypePlante $plante): self
    {
        $this->plante = $plante;

        return $this;
    }

    /**
     * @return Collection<int, LafleurCommandes>
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(LafleurCommandes $commande): self
    {
        if (!$this->commande->contains($commande)) {
            $this->commande->add($commande);
            $commande->addProduit($this);
        }

        return $this;
    }

    public function removeCommande(LafleurCommandes $commande): self
    {
        if ($this->commande->removeElement($commande)) {
            $commande->removeProduit($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, LafleurCategories>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(LafleurCategories $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(LafleurCategories $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

}
