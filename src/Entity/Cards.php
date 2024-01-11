<?php

namespace App\Entity;

use App\Repository\CardsRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Service\DateTimeConverter;

#[ORM\Entity(repositoryClass: CardsRepository::class)]
class Cards
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $crd_id = null;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $crd_created_at = null;

    #[ORM\Column(length: 255)]
    private ?string $crd_title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $crd_desc = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $crd_from = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $crd_to = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: "typ_id", nullable: false)]
    private ?Types $crd_typ = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: "sbj_id")]
    private ?Subjects $crd_sbj = null;

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

    public function getCrdTo(): ?\DateTimeInterface
    {
        return $this->crd_to;
    }

    public function getFormattedCrdTo(): string
    {
        $converter = new DateTimeConverter();

        return $converter->convertToString($this->getCrdTo());
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

    public function getTimeLeft(): string
    {
        $now = new \DateTime();
        $final = $this->getCrdTo();

        return $now->diff($final)->format('%a jours');
    }

    public
    function getCrdTypId(): ?Types
    {
        return $this->crd_typ;
    }

    public
    function setCrdTypId(
        ?Types $crd_typ
    ): static {
        $this->crd_typ = $crd_typ;

        return $this;
    }

    public function getCrdSbj(): ?Subjects
    {
        return $this->crd_sbj;
    }

    public function setCrdSbj(?Subjects $crd_sbj): static
    {
        $this->crd_sbj = $crd_sbj;

        return $this;
    }
}
