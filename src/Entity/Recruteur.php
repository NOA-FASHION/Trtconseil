<?php

namespace App\Entity;

use App\Repository\RecruteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: RecruteurRepository::class)]
class Recruteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    private ?string $NameEntreprise = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    private ?string $adresseEntreprise = null;

    #[ORM\OneToMany(mappedBy: 'recruteur', targetEntity: Annonce::class)]
    private Collection $Annonce;

    #[ORM\OneToOne(inversedBy: 'recruteur', cascade: ['persist', 'remove'])]
    private ?User $userRecrutueur = null;

    public function __construct()
    {
        $this->Annonce = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnonce(): Collection
    {
        return $this->Annonce;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->Annonce->contains($annonce)) {
            $this->Annonce->add($annonce);
            $annonce->setRecruteur($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->Annonce->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getRecruteur() === $this) {
                $annonce->setRecruteur(null);
            }
        }

        return $this;
    }

    public function getUserRecrutueur(): ?User
    {
        return $this->userRecrutueur;
    }

    public function setUserRecrutueur(?User $userRecrutueur): self
    {
        $this->userRecrutueur = $userRecrutueur;

        return $this;
    }
}
