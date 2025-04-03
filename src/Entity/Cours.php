<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?Inscription $Inscription = null;

    #[ORM\ManyToMany(targetEntity: Module::class, mappedBy: 'cours')]
    private Collection $Module;

    public function __construct()
    {
        $this->Module = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getInscription(): ?Inscription
    {
        return $this->Inscription;
    }

    public function setInscription(?Inscription $Inscription): static
    {
        $this->Inscription = $Inscription;

        return $this;
    }

    /**
     * @return Collection<int, Module>
     */
    public function getModule(): Collection
    {
        return $this->Module;
    }

    public function addModule(Module $module): static
    {
        if (!$this->Module->contains($module)) {
            $this->Module->add($module);
            $module->addCour($this);
        }

        return $this;
    }

    public function removeModule(Module $module): static
    {
        if ($this->Module->removeElement($module)) {
            $module->removeCour($this);
        }

        return $this;
    }
}
