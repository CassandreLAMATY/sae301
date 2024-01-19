<?php

namespace App\Entity;

use App\Repository\TypesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypesRepository::class)]
class Types
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $typ_id = null;

    #[ORM\Column(length: 20)]
    private ?string $typ_name = null;

    #[ORM\Column(length: 9)]
    private ?string $typ_color = null;

    public function getTypId(): ?int
    {
        return $this->typ_id;
    }

    public function getTypName(): ?string
    {
        return $this->typ_name;
    }

    public function setTypName(string $typ_name): static
    {
        $this->typ_name = $typ_name;

        return $this;
    }

    public function getTypColor(): ?string
    {
        return $this->typ_color;
    }

    public function setTypColor(string $typ_color): static
    {
        $this->typ_color = $typ_color;

        return $this;
    }
}
