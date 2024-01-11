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

    #[ORM\Column(options: ["default" => 0])]
    private ?bool $is_seen = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: "crd_id")]
    private ?Cards $not_card = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: "usr_id")]
    private ?Users $not_sender = null;

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

    public function isIsSeen(): ?bool
    {
        return $this->is_seen;
    }

    public function setIsSeen(bool $is_seen): static
    {
        $this->is_seen = $is_seen;

        return $this;
    }

    public function getNotCard(): ?Cards
    {
        return $this->not_card;
    }

    public function setNotCard(?Cards $not_card): static
    {
        $this->not_card = $not_card;

        return $this;
    }

    public function getNotSender(): ?Users
    {
        return $this->not_sender;
    }

    public function setNotSender(?Users $not_sender): static
    {
        $this->not_sender = $not_sender;

        return $this;
    }
}
