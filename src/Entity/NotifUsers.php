<?php

namespace App\Entity;

use App\Repository\NotifUsersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotifUsersRepository::class)]
class NotifUsers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $nu_id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: "not_id", nullable: false)]
    private ?Notifications $nu_not = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: "usr_id", nullable: false)]
    private ?Users $nu_usr = null;

    public function getId(): ?int
    {
        return $this->nu_id;
    }

    public function getNuNot(): ?Notifications
    {
        return $this->nu_not;
    }

    public function setNuNot(?Notifications $nu_not): static
    {
        $this->nu_not = $nu_not;

        return $this;
    }

    public function getNuUsr(): ?Users
    {
        return $this->nu_usr;
    }

    public function setNuUsr(?Users $nu_usr): static
    {
        $this->nu_usr = $nu_usr;

        return $this;
    }
}
