<?php

namespace App\Entity;

use App\Repository\JokerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JokerRepository::class)]
class Joker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $utilise = false;

    public function isUtilise(): bool
    {
        return $this->utilise;
    }

    public function setUtilise(bool $utilise): void
    {
        $this->utilise = $utilise;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
