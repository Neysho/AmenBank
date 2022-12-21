<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 * @ORM\Table(name="`account`")
 * @UniqueEntity(fields={"number"}, message="Ce numero existe deja")
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Devise;

    /**
     * @ORM\Column(type="float")
     */
    private $solde;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_solde;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="accounts")
     */
    private $User;

    /**
     * @ORM\OneToMany(targetEntity=Virement::class, mappedBy="Account", orphanRemoval=true)
     */
    private $virements;

    /**
     * @ORM\OneToMany(targetEntity=Virement::class, mappedBy="Account_2", orphanRemoval=true)
     */
    private $virements_2;

    public function __construct()
    {
        $this->virements = new ArrayCollection();
        $this->virements_2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDevise(): ?string
    {
        return $this->Devise;
    }

    public function setDevise(?string $Devise): self
    {
        $this->Devise = $Devise;

        return $this;
    }

    public function getSolde(): ?float
    {
        return $this->solde;
    }

    public function setSolde(float $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getDate_Solde(): ?\DateTimeInterface
    {
        return $this->date_solde;
    }

    public function setDate_Solde(?\DateTimeInterface $date_solde): self
    {
        $this->date_solde = $date_solde;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection<int, Virement>
     */
    public function getVirements(): Collection
    {
        return $this->virements;
    }

    public function addVirement(Virement $virement): self
    {
        if (!$this->virements->contains($virement)) {
            $this->virements[] = $virement;
            $virement->setAccount($this);
        }

        return $this;
    }

    public function removeVirement(Virement $virement): self
    {
        if ($this->virements->removeElement($virement)) {
            // set the owning side to null (unless already changed)
            if ($virement->getAccount() === $this) {
                $virement->setAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Virement>
     */
    public function getVirements2(): Collection
    {
        return $this->virements_2;
    }

    public function addVirements2(Virement $virements2): self
    {
        if (!$this->virements_2->contains($virements2)) {
            $this->virements_2[] = $virements2;
            $virements2->setAccount2($this);
        }

        return $this;
    }

    public function removeVirements2(Virement $virements2): self
    {
        if ($this->virements_2->removeElement($virements2)) {
            // set the owning side to null (unless already changed)
            if ($virements2->getAccount2() === $this) {
                $virements2->setAccount2(null);
            }
        }

        return $this;
    }
}
