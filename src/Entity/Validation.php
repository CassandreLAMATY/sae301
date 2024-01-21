<?php

namespace App\Entity;

use App\Repository\ValidationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ValidationRepository::class)]
class Validation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: "usr_id", nullable: false)]
    private ?Users $val_usr = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: "usr_id", nullable: false)]
    private ?Cards $val_crd = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValUsr(): ?Users
    {
        return $this->val_usr;
    }

    public function setValUsr(?Users $val_usr): static
    {
        $this->val_usr = $val_usr;

        return $this;
    }

    public function getValCrd(): ?Cards
    {
        return $this->val_crd;
    }

    public function setValCrd(?Cards $val_crd): static
    {
        $this->val_crd = $val_crd;

        return $this;
    }
}
