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

    #[ORM\Column(options: ["default" => "0"])]
    private ?bool $not_isSeen = null;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $not_created_at = null;

    public function getId(): ?int
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

    public function isNotIsSeen(): ?bool
    {
        return $this->not_isSeen;
    }

    public function setNotIsSeen(bool $not_isSeen): static
    {
        $this->not_isSeen = $not_isSeen;

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
}
