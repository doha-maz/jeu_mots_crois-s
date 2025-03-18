<?php

namespace App\Entity;

use App\Repository\MotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity(repositoryClass: MotRepository::class)]
class Mot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $mot = null;

    #[ORM\Column(type: 'text')]
    private ?string $definition = null;

    #[ORM\Column(type: 'boolean')]
    private bool $horizontal;

    #[ORM\Column(type: 'integer')]
    private int $longueur;

    #[ORM\ManyToMany(targetEntity: CaseM::class, mappedBy: 'mots')]
    private Collection $cases;

    #[ORM\OneToMany(targetEntity: Funfact::class, mappedBy: 'mot')]
    private Collection $funfacts;

    public function __construct()
    {
        $this->cases = new ArrayCollection();
        $this->funfacts = new ArrayCollection();
    }

    public function getCases(): Collection
    {
        return $this->cases;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMot(): ?string
    {
        return $this->mot;
    }

    public function setMot(?string $mot): void
    {
        $this->mot = $mot;
    }

    public function getDefinition(): ?string
    {
        return $this->definition;
    }

    public function setDefinition(?string $definition): void
    {
        $this->definition = $definition;
    }

    public function isHorizontal(): bool
    {
        return $this->horizontal;
    }

    public function setHorizontal(bool $horizontal): void
    {
        $this->horizontal = $horizontal;
    }

    public function getLongueur(): int
    {
        return $this->longueur;
    }

    public function addCase(CaseM $case): self
    {
        if (!$this->cases->contains($case)) {
            $this->cases->add($case);
            $case->addMot($this);
        }

        return $this;
    }

    public function removeCase(CaseM $case): self
    {
        if ($this->cases->removeElement($case)) {
            $case->removeMot($this);
        }

        return $this;
    }

    public function setLongueur(int $longueur): void
    {
        $this->longueur = $longueur;
    }

}
