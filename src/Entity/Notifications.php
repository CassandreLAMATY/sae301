<?php

namespace App\Entity;

use App\Repository\NotificationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationsRepository::class)]
class Notifications
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $not_id = null;

    #[ORM\Column(length: 100)]
    private ?string $not_title = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $not_content = null;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $not_created_at = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: "typ_id", nullable: false)]
    private ?Types $not_type = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: "sbj_id")]
    private ?Subjects $not_subject = null;

    public function getNotId(): ?int
    {
        return $this->not_id;
    }

    public function getNotTitle(): ?string
    {
        return $this->not_title;
    }

    public function setNotTitle(string $not_title): static
    {
        $this->not_title = $not_title;

        return $this;
    }

    public function getNotContent(): ?string
    {
        return $this->not_content;
    }

    public function setNotContent(?string $not_content): static
    {
        $this->not_content = $not_content;

        return $this;
    }

    public function getNotCreatedAt(): ?\DateTimeImmutable
    {
        return $this->not_created_at;
    }

    public function setNotCreatedAt(\DateTimeImmutable $not_created_at): static
    {
        $this->not_created_at = $not_created_at;

        return $this;
    }

    public function getNotType(): ?Types
    {
        return $this->not_type;
    }

    public function setNotType(?Types $not_type): static
    {
        $this->not_type = $not_type;

        return $this;
    }

    public function getNotSubject(): ?Subjects
    {
        return $this->not_subject;
    }

    public function setNotSubject(?Subjects $not_subject): static
    {
        $this->not_subject = $not_subject;

        return $this;
    }
}
