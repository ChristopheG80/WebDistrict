<?php

namespace App\Entity;

use App\Repository\MoyenPaiementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoyenPaiementRepository::class)]
class MoyenPaiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $code = null;

    #[ORM\Column(length: 50)]
    private ?string $libelle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }
}
