<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;


#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    operations: [
        new Get(),  
        new Put(),
        new Patch(),
    //    new Delete(),
        new GetCollection(),
        new Post(),
    ]
)]
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
    private Collection $details;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Utilisateur $utilisateur = null;

    #[ORM\Column(length: 100)]
    private ?string $liv_adresse = null;

    #[ORM\Column(length: 5)]
    private ?string $liv_cp = null;

    #[ORM\Column(length: 100)]
    private ?string $liv_ville = null;

    #[ORM\Column(length: 100)]
    private ?string $liv_telephone = null;

    #[ORM\Column(length: 100)]
    private ?string $fact_adresse = null;

    #[ORM\Column(length: 5)]
    private ?string $fact_cp = null;

    #[ORM\Column(length: 100)]
    private ?string $fact_ville = null;

    const _COMMANDE_ENREGISTREE_PAYEE = 0;
    const _COMMANDE_EN_PREPARATION = 1;
    const _COMMANDE_EN_COURS_DE_LIVRAISON = 2;
    const _COMMANDE_LIVREE = 3;

    private $mailer;
    public function __construct()
    {
        $this->details = new ArrayCollection();
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
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): static
    {
        if (!$this->details->contains($detail)) {
            $this->details->add($detail);
            $detail->setCommande($this);
        }
        return $this;
    }

    public function removeDetail(Detail $detail): static
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getCommande() === $this) {
                $detail->setCommande(null);
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

    public function getLivAdresse(): ?string
    {
        return $this->liv_adresse;
    }

    public function setLivAdresse(string $liv_adresse): static
    {
        $this->liv_adresse = $liv_adresse;

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

    public function getLivTelephone(): ?string
    {
        return $this->liv_telephone;
    }

    public function setLivTelephone(string $livTelephone): static
    {
        $this->liv_telephone = $livTelephone;

        return $this;
    }



    public function getfactAdresse(): ?string
    {
        return $this->fact_adresse;
    }

    public function setfactAdresse(string $fact_adresse): static
    {
        $this->fact_adresse = $fact_adresse;

        return $this;
    }

    
    public function getfactCp(): ?string
    {
        return $this->fact_cp;
    }

    public function setfactCp(string $fact_cp): static
    {
        $this->fact_cp = $fact_cp;

        return $this;
    }

    public function getfactVille(): ?string
    {
        return $this->fact_ville;
    }

    public function setfactVille(string $fact_ville): static
    {
        $this->fact_ville = $fact_ville;

        return $this;
    }
}
