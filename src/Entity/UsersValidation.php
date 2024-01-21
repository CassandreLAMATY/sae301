<?php

namespace App\Entity;

use App\Repository\UsersValidationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersValidationRepository::class)]
class UsersValidation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $uv_id = null;

    #[ORM\Column]
    private ?bool $uv_valid = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: "usr_id")]
    private ?Users $uv_usr = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: "crd_id")]
    private ?Cards $uv_crd = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $isUvValidated = null;

    public function getId(): ?int
    {
        return $this->uv_id;
    }

    public function getUvValidated(): ?int
    {
        return $this->uv_valid;
    }

    public function setUvValidated(int $uv_valid): static
    {
        $this->uv_valid = $uv_valid;

        return $this;
    }

    public function getUvUsr(): ?Users
    {
        return $this->uv_usr;
    }

    public function setUvUsr(?Users $uv_usr): static
    {
        $this->uv_usr = $uv_usr;

        return $this;
    }

    public function getUvCrd(): ?Cards
    {
        return $this->uv_crd;
    }

    public function setUvCrd(?Cards $uv_crd): static
    {
        $this->uv_crd = $uv_crd;

        return $this;
    }

    public function getIsUvValidated(): ?int
    {
        return $this->isUvValidated;
    }

    public function setIsUvValidated(int $isUvValidated): static
    {
        $this->isUvValidated = $isUvValidated;

        return $this;
    }
}
