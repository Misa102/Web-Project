<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'i23_produits')]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $denomination = null;

    #[ORM\Column(type: Types::STRING, length: 30, options:['comment' => 'code barre'])]
    private ?string $code = null;

    #[ORM\Column(name:'date_creation', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private ?bool $actif = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptif = null;

    #[ORM\OneToOne(targetEntity: Manuel::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name:'id_manuel', referencedColumnName: 'id', unique: true, nullable: true, options: ['default' => null],)]
    private ?Manuel $manuel = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Image::class)]
    private Collection $images;

    #[ORM\ManyToMany(targetEntity: Pays::class, inversedBy: 'produits')]
    #[ORM\JoinTable(name: 'i23_produits_pays')]
    #[ORM\JoinColumn(name: 'id_produit', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'id_pays', referencedColumnName: 'id')]
    private Collection $payss;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: ProduitMagasin::class)]
    private Collection $produitMagasins;




    /**
     * constructeur Produit: une initialisation ds le construc indique explicitement qu'on veut la faire
     * et si un membre n'est pas initialisé ds le construc alors il faudra l'init par ailleurs
     */
    public function __construct()
    {
        $this->actif = false;
        $this->manuel = null;
        $this->images = new ArrayCollection();
        $this->payss = new ArrayCollection();
        $this->produitMagasins = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(string $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    public function getManuel(): ?Manuel
    {
        return $this->manuel;
    }

    public function setManuel(Manuel $manuel): self
    {
        $this->manuel = $manuel;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProduit($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduit() === $this) {
                $image->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pays>
     */
    public function getPayss(): Collection
    {
        return $this->payss;
    }

    public function addPayss(Pays $payss): self
    {
        if (!$this->payss->contains($payss)) {
            $this->payss->add($payss);
        }

        return $this;
    }

    public function removePayss(Pays $payss): self
    {
        $this->payss->removeElement($payss);

        return $this;
    }

    /**
     * @return Collection<int, ProduitMagasin>
     */
    public function getProduitMagasins(): Collection
    {
        return $this->produitMagasins;
    }

    public function addProduitMagasin(ProduitMagasin $produitMagasin): self
    {
        if (!$this->produitMagasins->contains($produitMagasin)) {
            $this->produitMagasins->add($produitMagasin);
            $produitMagasin->setProduit($this);
        }

        return $this;
    }

    public function removeProduitMagasin(ProduitMagasin $produitMagasin): self
    {
        if ($this->produitMagasins->removeElement($produitMagasin)) {
            // set the owning side to null (unless already changed)
            if ($produitMagasin->getProduit() === $this) {
                $produitMagasin->setProduit(null);
            }
        }

        return $this;
    }
}
