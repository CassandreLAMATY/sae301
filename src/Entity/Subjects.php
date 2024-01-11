<?php

namespace App\Entity;

use App\Repository\SubjectsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjectsRepository::class)]
class Subjects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $sbj_id = null;

    #[ORM\Column(length: 200)]
    private ?string $sbj_name = null;

    #[ORM\Column(length: 9)]
    private ?string $sbj_color = null;

    public function getId(): ?int
    {
        return $this->sbj_id;
    }

    public function getSbjName(): ?string
    {
        return $this->sbj_name;
    }

    public function setSbjName(string $sbj_name): static
    {
        $this->sbj_name = $sbj_name;

        return $this;
    }

    public function getSbjColor(): ?string
    {
        return $this->sbj_color;
    }

    public function setSbjColor(string $sbj_color): static
    {
        $this->sbj_color = $sbj_color;

        return $this;
    }
}
