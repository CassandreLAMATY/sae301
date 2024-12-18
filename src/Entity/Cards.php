<?php

namespace App\Entity;

use App\Repository\CardsRepository;
use App\Entity\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Service\DateTimeConverter;

#[ORM\Entity(repositoryClass: CardsRepository::class)]
class Cards
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $crd_id = null;

    private ?int $crd_grp = null;

    #[ORM\Column(options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $crd_created_at = null;

    #[ORM\Column(length: 100)]
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

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::SMALLINT, options: ["default" => "0"])]
    private ?int $is_validated = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::SMALLINT, nullable: true)]
    private ?int $validated_by = null;

    public function getCrdId(): ?int
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

    public function getSmallCrdTo(): string
    {
        $moisFrancais = [
            'Jan' => 'Jan',
            'Feb' => 'Fév',
            'Mar' => 'Mar',
            'Apr' => 'Avr',
            'May' => 'Mai',
            'Jun' => 'Juin',
            'Jul' => 'Juil',
            'Aug' => 'Août',
            'Sep' => 'Sep',
            'Oct' => 'Oct',
            'Nov' => 'Nov',
            'Dec' => 'Déc',
        ];

        $formattedDate = $this->getCrdTo()->format('d ') . $moisFrancais[$this->getCrdTo()->format('M')];

        return $formattedDate;
    }

    public function getFormattedCrdTo(): string
    {
        $formatter = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);
        $formatter->setPattern("d MMMM yyyy 'à' HH:mm");
        return $formatter->format($this->getCrdTo()->getTimestamp());
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

    public function getSmallCrdFrom(): ?string
    {
        if ($this->getCrdFrom() === null) {
            return null;
        }

        $moisFrancais = [
            'Jan' => 'Jan',
            'Feb' => 'Fév',
            'Mar' => 'Mar',
            'Apr' => 'Avr',
            'May' => 'Mai',
            'Jun' => 'Juin',
            'Jul' => 'Juil',
            'Aug' => 'Août',
            'Sep' => 'Sep',
            'Oct' => 'Oct',
            'Nov' => 'Nov',
            'Dec' => 'Déc',
        ];

        $formattedDate = $this->getCrdFrom()->format('d ') . $moisFrancais[$this->getCrdFrom()->format('M')];

        return $formattedDate;
    }

    public function getFormattedCrdFrom(): string
    {
        $formatter = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);
        $formatter->setPattern("d MMMM yyyy 'à' HH:mm");
        return $formatter->format($this->getCrdFrom()->getTimestamp());
    }

    public function setCrdFrom(?\DateTimeInterface $crd_from): static
    {
        $this->crd_from = $crd_from;

        return $this;
    }

    public function getTimeLeft(): string
    {
        $final = $this->getCrdTo();

        if($this->getCrdFrom()){
            $final = $this->getCrdFrom();
        }

        $now = new \DateTime(null, new \DateTimeZone('Europe/Paris'));

        $final->setTimezone(new \DateTimeZone('Europe/Paris'));

        $diff = $now->diff($final);
        $dayLeft = $diff->format('%a');
        $hourLeft = $diff->format('%h');
        $hourLeft = (int)$hourLeft;

        if ($dayLeft === '0' && $hourLeft > 1 ) {
            return sprintf('%dh%02d', $diff->h, $diff->i);
        }

        if ($dayLeft === '0' && $hourLeft === 0) {
            return $diff->format('%i min');
        }

        return $diff->format('%a jours');
    }

    public
    function getCrdTyp(): ?Types
    {
        return $this->crd_typ;
    }

    public
    function setCrdTyp(
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


    public function getValidatedBy(): ?int
    {
        return $this->validated_by;
    }

    public function setValidatedBy(?int $validated_by): static
    {
        $this->validated_by = $validated_by;

        return $this;
    }

    public function getIsValidated(): ?int
    {
        return $this->is_validated;
    }

    public function setIsValidated(int $is_validated): static
    {
        $this->is_validated = $is_validated;

        return $this;
    }

    public function getCrdGrp(): ?int
    {
        return $this->crd_grp;
    }

    public function setCrdGrp(?int $crd_grp = null): void
    {
        $this->crd_grp = $crd_grp;
    }


}
