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

    #[ORM\Column]
    private ?int $not_usr_id = null;

    #[ORM\Column(length: 20)]
    private ?string $not_type = null;

    #[ORM\Column(length: 100)]
    private ?string $not_content = null;

    #[ORM\Column(nullable: true)]
    private ?int $not_crd_id = null;

    #[ORM\Column(nullable: true)]
    private ?int $not_sender_id = null;

    public function getId(): ?int
    {
        return $this->not_id;
    }

    public function getNotUsrId(): ?int
    {
        return $this->not_usr_id;
    }

    public function setNotUsrId(int $not_usr_id): static
    {
        $this->not_usr_id = $not_usr_id;

        return $this;
    }

    public function getNotType(): ?string
    {
        return $this->not_type;
    }

    public function setNotType(string $not_type): static
    {
        $this->not_type = $not_type;

        return $this;
    }

    public function getNotContent(): ?string
    {
        return $this->not_content;
    }

    public function setNotContent(string $not_content): static
    {
        $this->not_content = $not_content;

        return $this;
    }

    public function getNotCrdId(): ?int
    {
        return $this->not_crd_id;
    }

    public function setNotCrdId(?int $not_crd_id): static
    {
        $this->not_crd_id = $not_crd_id;

        return $this;
    }

    public function getNotSenderId(): ?int
    {
        return $this->not_sender_id;
    }

    public function setNotSenderId(?int $not_sender_id): static
    {
        $this->not_sender_id = $not_sender_id;

        return $this;
    }
}
