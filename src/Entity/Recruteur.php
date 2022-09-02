<?php

namespace App\Entity;

use App\Repository\RecruteurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecruteurRepository::class)]
class Recruteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $NameEntreprise = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresseEntreprise = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameEntreprise(): ?string
    {
        return $this->NameEntreprise;
    }

    public function setNameEntreprise(string $NameEntreprise): self
    {
        $this->NameEntreprise = $NameEntreprise;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getAdresseEntreprise(): ?string
    {
        return $this->adresseEntreprise;
    }

    public function setAdresseEntreprise(?string $adresseEntreprise): self
    {
        $this->adresseEntreprise = $adresseEntreprise;

        return $this;
    }
}
