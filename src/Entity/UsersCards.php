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
    private ?int $uc_id = null;

    #[ORM\Column]
    private ?bool $uc_done = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: "usr_id")]
    private ?Users $uc_usr = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: "crd_id")]
    private ?Cards $uc_crd = null;

    public function getId(): ?int
    {
        return $this->uc_id;
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

    public function getUcUsr(): ?Users
    {
        return $this->uc_usr;
    }

    public function setUcUsr(?Users $uc_usr): static
    {
        $this->uc_usr = $uc_usr;

        return $this;
    }

    public function getUcCrd(): ?Cards
    {
        return $this->uc_crd;
    }

    public function setUcCrd(?Cards $uc_crd): static
    {
        $this->uc_crd = $uc_crd;

        return $this;
    }
}
