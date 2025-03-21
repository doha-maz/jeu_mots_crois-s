<?php

namespace App\Entity;

use App\Repository\LettresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LettresRepository::class)]
class Lettres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 1)]
    private ?string $contenu;

    #[ORM\Column(type: 'integer')]
    private ?int $positionX;

    #[ORM\Column(type: 'integer')]
    private ?int $positionY;

    #[ORM\ManyToMany(targetEntity: Mot::class, mappedBy: 'lettres')]
    private Collection $mots;

    public function __construct()
    {
        $this->mots = new ArrayCollection();
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): void
    {
        $this->contenu = $contenu;
    }

    public function getPositionX(): ?int
    {
        return $this->positionX;
    }

    public function setPositionX(?int $positionX): void
    {
        $this->positionX = $positionX;
    }

    public function getPositionY(): ?int
    {
        return $this->positionY;
    }

    public function setPositionY(?int $positionY): void
    {
        $this->positionY = $positionY;
    }

    public function getMots(): Collection
    {
        return $this->mots;
    }

    public function setMots(Collection $mots): void
    {
        $this->mots = $mots;
    }


    public function getId(): ?int
    {
        return $this->id;
    }


}
