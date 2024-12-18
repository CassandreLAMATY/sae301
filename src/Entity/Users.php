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

    #[ORM\Column(length: 200)]
    private ?string $usr_pwd = null;

    #[ORM\Column(length: 20)]
    private ?string $usr_role = null;

    #[ORM\Column(length: 50)]
    private ?string $usr_name = null;

    #[ORM\Column(length: 50)]
    private ?string $usr_firstname = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $usr_tp = null;

    #[ORM\Column(options: ["default" => 0])]
    private ?bool $usr_banned = null;

    #[ORM\Column(length: 8)]
    private ?string $usr_pseudo = null;

    #[ORM\Column(length: 2)]
    private ?string $usr_semester = null;

    #[ORM\Column]
    private ?bool $usr_homework_reminder = false;

    #[ORM\Column]
    private ?bool $usr_exam_reminder = false;

    #[ORM\Column]
    private ?bool $usr_new_reminder = false;

    #[ORM\Column]
    private ?bool $usr_modif_reminder = false;

    #[ORM\Column]
    private ?bool $usr_cookies = false;

    public function getUsrId(): ?int
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

    public function getUsrPseudo(): ?string
    {
        return $this->usr_pseudo;
    }

    public function setUsrPseudo(string $usr_pseudo): static
    {
        $this->usr_pseudo = $usr_pseudo;

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
        return $this->getUsrPseudo(); //changer ici si on veut se connecter avec le pseudo

    }

    public function getUsrSemester(): ?string
    {
        return $this->usr_semester;
    }

    public function setUsrSemester(string $usr_semester): static
    {
        $this->usr_semester = $usr_semester;

        return $this;
    }

    public function isUsrHomeworkReminder(): ?bool
    {
        return $this->usr_homework_reminder;
    }

    public function setUsrHomeworkReminder(bool $usr_homework_reminder): static
    {
        $this->usr_homework_reminder = $usr_homework_reminder;

        return $this;
    }

    public function isUsrExamReminder(): ?bool
    {
        return $this->usr_exam_reminder;
    }

    public function setUsrExamReminder(bool $usr_exam_reminder): static
    {
        $this->usr_exam_reminder = $usr_exam_reminder;

        return $this;
    }

    public function isUsrNewReminder(): ?bool
    {
        return $this->usr_new_reminder;
    }

    public function setUsrNewReminder(bool $usr_new_reminder): static
    {
        $this->usr_new_reminder = $usr_new_reminder;

        return $this;
    }

    public function isUsrModifReminder(): ?bool
    {
        return $this->usr_modif_reminder;
    }

    public function setUsrModifReminder(bool $usr_modif_reminder): static
    {
        $this->usr_modif_reminder = $usr_modif_reminder;

        return $this;
    }

    public function isUsrCookies(): ?bool
    {
        return $this->usr_cookies;
    }

    public function setUsrCookies(bool $usr_cookies): static
    {
        $this->usr_cookies = $usr_cookies;

        return $this;
    }

    public function setId(?Notifications $id): static
    {
        $this->id = $id;

        return $this;
    }
}
