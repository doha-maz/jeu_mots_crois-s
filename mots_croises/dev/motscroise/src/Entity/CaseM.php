<?php

namespace App\Entity;

use App\Repository\CaseMRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CaseMRepository::class)]
class CaseM
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private int $positionX;

    #[ORM\Column(type: 'integer')]
    private int $positionY;

    #[ORM\Column(type: 'string', length: 1)]
    private string $contenu;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $affiche = false;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $casePartage = false;

    #[ORM\ManyToMany(targetEntity: Mot::class, inversedBy: 'cases')]
    #[ORM\JoinTable(name: 'case_mot')]
    private Collection $mots;

    public function __construct()
    {
        $this->mots = new ArrayCollection() ;
    }

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $numero = null;


    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(?int $numero): self
    {
        $this->numero = $numero;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPositionX(): int
    {
        return $this->positionX;
    }

    public function setPositionX(int $positionX): void
    {
        $this->positionX = $positionX;
    }

    public function getPositionY(): int
    {
        return $this->positionY;
    }

    public function setPositionY(int $positionY): void
    {
        $this->positionY = $positionY;
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): void
    {
        $this->contenu = $contenu;
    }

    public function isAffiche(): bool
    {
        return $this->affiche;
    }

    public function setAffiche(bool $affiche): void
    {
        $this->affiche = $affiche;
    }

    public function isCasePartage(): bool
    {
        return $this->casePartage;
    }

    public function setCasePartage(bool $casePartage): void
    {
        $this->casePartage = $casePartage;
    }

    public function getMots(): Collection
    {
        return $this->mots;
    }

    public function setMots(Collection $mots): void
    {
        $this->mots = $mots;
    }





    public function addMot(Mot $mot): self
    {
        if (!$this->mots->contains($mot)) {
            $this->mots[] = $mot;
        }

        return $this;
    }

    public function removeMot(Mot $mot): self
    {
        $this->mots->removeElement($mot);

        return $this;
    }




}
