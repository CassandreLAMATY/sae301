<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $usr_id = null;

    #[ORM\Column(length: 100)]
    private ?string $usr_mail = null;

    #[ORM\Column(length: 50)]
    private ?string $usr_pwd = null;

    #[ORM\Column(length: 20)]
    private ?string $usr_role = null;

    #[ORM\Column(length: 50)]
    private ?string $usr_name = null;

    #[ORM\Column(length: 50)]
    private ?string $usr_firstname = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $usr_pp = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $usr_tp = null;

    #[ORM\Column(options: ["default" => 0])]
    private ?bool $usr_banned = null;

    public function getId(): ?int
    {
        return $this->usr_id;
    }

    public function getUsrMail(): ?string
    {
        return $this->usr_mail;
    }

    public function setUsrMail(string $usr_mail): static
    {
        $this->usr_mail = $usr_mail;

        return $this;
    }

    public function getUsrPwd(): ?string
    {
        return $this->usr_pwd;
    }

    public function setUsrPwd(string $usr_pwd): static
    {
        $this->usr_pwd = $usr_pwd;

        return $this;
    }

    public function getUsrRole(): ?string
    {
        return $this->usr_role;
    }

    public function setUsrRole(string $usr_role): static
    {
        $this->usr_role = $usr_role;

        return $this;
    }

    public function getUsrName(): ?string
    {
        return $this->usr_name;
    }

    public function setUsrName(string $usr_name): static
    {
        $this->usr_name = $usr_name;

        return $this;
    }

    public function getUsrFirstname(): ?string
    {
        return $this->usr_firstname;
    }

    public function setUsrFirstname(string $usr_firstname): static
    {
        $this->usr_firstname = $usr_firstname;

        return $this;
    }

    public function getUsrPP(): ?string
    {
        return $this->usr_pp;
    }

    public function setUsrPP(string $usr_pp): static
    {
        $this->usr_pp = $usr_pp;

        return $this;
    }

    public function getUsrTp(): ?string
    {
        return $this->usr_tp;
    }

    public function setUsrTp(?string $usr_tp): static
    {
        $this->usr_tp = $usr_tp;

        return $this;
    }

    public function isUsrBanned(): ?bool
    {
        return $this->usr_banned;
    }

    public function setUsrBanned(bool $usr_banned): static
    {
        $this->usr_banned = $usr_banned;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->getUsrPwd();
    }

    public function getRoles(): array
    {

    return [$this->getUsrRole()];
    }

    public function eraseCredentials(): void
    {
            // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->getUsrMail();//changer ici si on veut se connecter avec le pseudo
    }
}
