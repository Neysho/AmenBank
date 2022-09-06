<?php

namespace App\Entity;

use App\Repository\CreditRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CreditRepository::class)
 */
class Credit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $c_cin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Attestation_Travail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Attestation_Salaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Document_Credit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="credits")
     */
    private $User;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCCin(): ?string
    {
        return $this->c_cin;
    }

    public function setCCin(string $c_cin): self
    {
        $this->c_cin = $c_cin;

        return $this;
    }

    public function getAttestationTravail(): ?string
    {
        return $this->Attestation_Travail;
    }

    public function setAttestationTravail(string $Attestation_Travail): self
    {
        $this->Attestation_Travail = $Attestation_Travail;

        return $this;
    }

    public function getAttestationSalaire(): ?string
    {
        return $this->Attestation_Salaire;
    }

    public function setAttestationSalaire(string $Attestation_Salaire): self
    {
        $this->Attestation_Salaire = $Attestation_Salaire;

        return $this;
    }

    public function getDocumentCredit(): ?string
    {
        return $this->Document_Credit;
    }

    public function setDocumentCredit(string $Document_Credit): self
    {
        $this->Document_Credit = $Document_Credit;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(?string $Status): self
    {
        $this->Status = $Status;

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
}
