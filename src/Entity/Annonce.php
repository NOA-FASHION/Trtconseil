<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\ManyToOne(inversedBy: 'Annonce')]
    private ?Recruteur $recruteur = null;

    #[ORM\Column(length: 70)]
    private ?string $intitulePoste = null;

    #[ORM\Column(length: 255)]
    private ?string $lieuTravail = null;

    #[ORM\Column(length: 50)]
    private ?string $horairePost = null;

    #[ORM\Column]
    private ?string $salaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $desciptionPoste = null;

    #[ORM\ManyToOne(inversedBy: 'annonces')]
    private ?User $useAnnonce = null;

    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: Candidature::class)]
    private Collection $candidature;

    #[ORM\ManyToMany(targetEntity: Candidat::class,mappedBy : 'annonces')]
    private Collection $candidat;

    public function __construct()
    {
        $this->candidature = new ArrayCollection();
        $this->candidat = new ArrayCollection();
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

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getRecruteur(): ?Recruteur
    {
        return $this->recruteur;
    }

    public function setRecruteur(?Recruteur $recruteur): self
    {
        $this->recruteur = $recruteur;

        return $this;
    }

    public function getIntitulePoste(): ?string
    {
        return $this->intitulePoste;
    }

    public function setIntitulePoste(string $intitulePoste): self
    {
        $this->intitulePoste = $intitulePoste;

        return $this;
    }

    public function getLieuTravail(): ?string
    {
        return $this->lieuTravail;
    }

    public function setLieuTravail(string $lieuTravail): self
    {
        $this->lieuTravail = $lieuTravail;

        return $this;
    }

    public function getHorairePost(): ?string
    {
        return $this->horairePost;
    }

    public function setHorairePost(string $horairePost): self
    {
        $this->horairePost = $horairePost;

        return $this;
    }

    public function getSalaire(): ?string
    {
        return $this->salaire;
    }

    public function setSalaire(string $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getDesciptionPoste(): ?string
    {
        return $this->desciptionPoste;
    }

    public function setDesciptionPoste(?string $desciptionPoste): self
    {
        $this->desciptionPoste = $desciptionPoste;

        return $this;
    }

    public function getUseAnnonce(): ?User
    {
        return $this->useAnnonce;
    }

    public function setUseAnnonce(?User $useAnnonce): self
    {
        $this->useAnnonce = $useAnnonce;

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
            $candidature->setAnnonce($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidature->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getAnnonce() === $this) {
                $candidature->setAnnonce(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Candidat>
     */
    public function getCandidat(): Collection
    {
        return $this->candidat;
    }

    public function addCandidat(Candidat $candidat): self
    {
        if (!$this->candidat->contains($candidat)) {
            $this->candidat->add($candidat);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): self
    {
        $this->candidat->removeElement($candidat);

        return $this;
    }

   
}
