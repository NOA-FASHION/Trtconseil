<?php

namespace App\Entity;

use App\Repository\CandidatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: CandidatRepository::class)]
class Candidat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\NotNull()]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column]
    private ?bool $activation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cvLien = null;

    #[ORM\OneToOne(inversedBy: 'candidat', cascade: ['persist', 'remove'])]
    private ?User $userCandidat = null;

    #[ORM\OneToMany(mappedBy: 'candidat', targetEntity: Candidature::class)]
    private Collection $candidature;

    public function __construct()
    {
        $this->candidature = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function isActivation(): ?bool
    {
        return $this->activation;
    }

    public function setActivation(bool $activation): self
    {
        $this->activation = $activation;

        return $this;
    }

    public function getCvLien(): ?string
    {
        return $this->cvLien;
    }

    public function setCvLien(?string $cvLien): self
    {
        $this->cvLien = $cvLien;

        return $this;
    }

    public function getUserCandidat(): ?User
    {
        return $this->userCandidat;
    }

    public function setUserCandidat(?User $userCandidat): self
    {
        $this->userCandidat = $userCandidat;

        return $this;
    }

    /**
     * @return Collection<int, Candidature>
     */
    public function getCandidature(): Collection
    {
        return $this->candidature;
    }

    public function addCandidature(Candidature $candidature): self
    {
        if (!$this->candidature->contains($candidature)) {
            $this->candidature->add($candidature);
            $candidature->setCandidat($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidature->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getCandidat() === $this) {
                $candidature->setCandidat(null);
            }
        }

        return $this;
    }
}
