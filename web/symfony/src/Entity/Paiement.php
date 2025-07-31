<?php

namespace App\Entity;

use App\Repository\PaiementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column(length: 100)]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Module $module = null;

    #[ORM\Column]
    private ?string $telephone = null;

    #[ORM\Column]
    private ?string $numerobancaire = null;

    #[ORM\Column(length: 100)]
    private ?string $nomtitulaire = null;

    #[ORM\Column(length: 10)]
    private ?string $CVV = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateExpiration = null;

    #[ORM\Column(length: 100)]
    private ?string $operateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): static
    {
        $this->module = $module;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getNumerobancaire(): ?string
    {
        return $this->numerobancaire;
    }

    public function setNumerobancaire(string $numerobancaire): static
    {
        $this->numerobancaire = $numerobancaire;

        return $this;
    }

    public function getNomtitulaire(): ?string
    {
        return $this->nomtitulaire;
    }

    public function setNomtitulaire(string $nomtitulaire): static
    {
        $this->nomtitulaire = $nomtitulaire;

        return $this;
    }

    public function getCVV(): ?string
    {
        return $this->CVV;
    }

    public function setCVV(string $CVV): static
    {
        $this->CVV = $CVV;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeImmutable
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(\DateTimeImmutable $dateExpiration): static
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function getOperateur(): ?string
    {
        return $this->operateur;
    }

    public function setOperateur(string $operateur): static
    {
        $this->operateur = $operateur;

        return $this;
    }
}
