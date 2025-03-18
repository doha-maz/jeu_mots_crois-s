<?php

namespace App\Entity;

use App\Repository\FunfactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FunfactRepository::class)]
class Funfact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Mot::class, inversedBy: 'funfacts')]
    #[ORM\JoinColumn(name: 'ID_Mot', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?Mot $mot = null;



    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getMot(): ?Mot
    {
        return $this->mot;
    }

    public function setMot(?Mot $mot): void
    {
        $this->mot = $mot;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
