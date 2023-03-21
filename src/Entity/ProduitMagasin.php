<?php

namespace App\Entity;

use App\Repository\ProduitMagasinRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Table(name: 'i23_produits_magasins')]
#[ORM\UniqueConstraint(columns: ['id_produit', 'id_magasin'])]
#[ORM\Entity(repositoryClass: ProduitMagasinRepository::class)]
class ProduitMagasin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\Range(minMessage: 'la quantité min est{{limit}}', min:0)]
    private ?int $quantite = null;

    #[ORM\Column(name: 'prix_unitaire', type: Types::FLOAT)]
    #[Assert\Range(minMessage: 'pas de prix négatif', min: 0)]
    private ?float $prixUnitaire = null;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'produitMagasins')]
    #[ORM\JoinColumn(name:'id_produit', nullable: false)]
    #[Assert\NotNull]
    #[Assert\Valid]
    private ?Produit $produit = null;

    #[ORM\ManyToOne(targetEntity: Magasin::class, inversedBy: 'produitMagasins')]
    #[ORM\JoinColumn(name: 'id_magasin', nullable: false)]
    #[Assert\NotNull]
    #[Assert\Valid]
    private ?Magasin $magasin = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrixUnitaire(): ?float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): self
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getMagasin(): ?Magasin
    {
        return $this->magasin;
    }

    public function setMagasin(?Magasin $magasin): self
    {
        $this->magasin = $magasin;

        return $this;
    }
}
