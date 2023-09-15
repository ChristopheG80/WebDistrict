<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_commande = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?string $total = null;

    #[ORM\Column]
    private ?int $etat = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: Detail::class)]
    private Collection $plat;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Utilisateur $utilisateur = null;

    #[ORM\Column(length: 100)]
    private ?string $liv_adresse1 = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $liv_adresse2 = null;

    #[ORM\Column(length: 5)]
    private ?string $liv_cp = null;

    #[ORM\Column(length: 100)]
    private ?string $liv_ville = null;

    const _COMMANDE_ENREGISTREE_PAYEE = 0;
    const _COMMANDE_EN_PREPARATION = 1;
    const _COMMANDE_EN_COURS_DE_LIVRAISON = 2;
    const _COMMANDE_LIVREE = 3;

    public function __construct()
    {
        $this->plat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): static
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): static
    {
        $this->etat = $etat;
        // codification champ état
        // 0. enregistrée/payée
        // 1. en préparation
        // 2. en cours de livraison
        // 3. livrée
        return $this;
    }

    /**
     * @return Collection<int, Detail>
     */
    public function getPlat(): Collection
    {
        return $this->plat;
    }

    public function addPlat(Detail $plat): static
    {
        if (!$this->plat->contains($plat)) {
            $this->plat->add($plat);
            $plat->setCommande($this);
        }

        return $this;
    }

    public function removePlat(Detail $plat): static
    {
        if ($this->plat->removeElement($plat)) {
            // set the owning side to null (unless already changed)
            if ($plat->getCommande() === $this) {
                $plat->setCommande(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getLivAdresse1(): ?string
    {
        return $this->liv_adresse1;
    }

    public function setLivAdresse1(string $liv_adresse1): static
    {
        $this->liv_adresse1 = $liv_adresse1;

        return $this;
    }

    public function getLivAdresse2(): ?string
    {
        return $this->liv_adresse2;
    }

    public function setLivAdresse2(?string $liv_adresse2): static
    {
        $this->liv_adresse2 = $liv_adresse2;

        return $this;
    }

    public function getLivCp(): ?string
    {
        return $this->liv_cp;
    }

    public function setLivCp(string $liv_cp): static
    {
        $this->liv_cp = $liv_cp;

        return $this;
    }

    public function getLivVille(): ?string
    {
        return $this->liv_ville;
    }

    public function setLivVille(string $liv_ville): static
    {
        $this->liv_ville = $liv_ville;

        return $this;
    }
}
