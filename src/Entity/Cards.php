<?php

namespace App\Entity;

use App\Repository\CardsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardsRepository::class)]
class Cards
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $crd_id = null;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $crd_created_at = null;

    #[ORM\Column(length: 20)]
    private ?string $crd_type = null;

    #[ORM\Column(length: 255)]
    private ?string $crd_title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $crd_desc = null;

    #[ORM\Column(nullable: true)]
    private ?int $crd_subject = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $crd_from = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $crd_to = null;

    public function getId(): ?int
    {
        return $this->crd_id;
    }

    public function getCrdCreatedAt(): ?\DateTimeImmutable
    {
        return $this->crd_created_at;
    }

    public function setCrdCreatedAt(\DateTimeImmutable $crd_created_at): static
    {
        $this->crd_created_at = $crd_created_at;

        return $this;
    }

    public function getCrdType(): ?string
    {
        return $this->crd_type;
    }

    public function setCrdType(string $crd_type): static
    {
        $this->crd_type = $crd_type;

        return $this;
    }

    public function getCrdTitle(): ?string
    {
        return $this->crd_title;
    }

    public function setCrdTitle(string $crd_title): static
    {
        $this->crd_title = $crd_title;

        return $this;
    }

    public function getCrdDesc(): ?string
    {
        return $this->crd_desc;
    }

    public function setCrdDesc(?string $crd_desc): static
    {
        $this->crd_desc = $crd_desc;

        return $this;
    }

    public function getCrdSubject(): ?int
    {
        return $this->crd_subject;
    }

    public function setCrdSubject(?int $crd_subject): static
    {
        $this->crd_subject = $crd_subject;

        return $this;
    }

    public function getCrdTo(): ?\DateTimeInterface
    {
        return $this->crd_to;
    }

    public function setCrdTo(\DateTimeInterface $crd_to): static
    {
        $this->crd_to = $crd_to;

        return $this;
    }

    public function getCrdFrom(): ?\DateTimeInterface
    {
        return $this->crd_from;
    }

    public function setCrdFrom(?\DateTimeInterface $crd_from): static
    {
        $this->crd_from = $crd_from;

        return $this;
    }
}
