<?php

namespace App\Entity;

use App\Repository\UsersCardsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersCardsRepository::class)]
class UsersCards
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $uc_usr_id = null;

    #[ORM\Column]
    private ?int $uc_card_id = null;

    #[ORM\Column]
    private ?bool $uc_done = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $uc_reminder = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUcUsrId(): ?int
    {
        return $this->uc_usr_id;
    }

    public function setUcUsrId(int $uc_usr_id): static
    {
        $this->uc_usr_id = $uc_usr_id;

        return $this;
    }

    public function getUcCardId(): ?int
    {
        return $this->uc_card_id;
    }

    public function setUcCardId(int $uc_card_id): static
    {
        $this->uc_card_id = $uc_card_id;

        return $this;
    }

    public function isUcDone(): ?bool
    {
        return $this->uc_done;
    }

    public function setUcDone(bool $uc_done): static
    {
        $this->uc_done = $uc_done;

        return $this;
    }

    public function getUcReminder(): ?\DateTimeInterface
    {
        return $this->uc_reminder;
    }

    public function setUcReminder(?\DateTimeInterface $uc_reminder): static
    {
        $this->uc_reminder = $uc_reminder;

        return $this;
    }
}
