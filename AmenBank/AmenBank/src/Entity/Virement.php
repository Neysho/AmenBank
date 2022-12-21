<?php

namespace App\Entity;

use App\Repository\VirementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VirementRepository::class)
 */
class Virement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $Montant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Motif;

    /**
     * @ORM\Column(type="date")
     */
    private $Date_Execution;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="virements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Account;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="virements_2")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Account_2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $devise;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->Montant;
    }

    public function setMontant(float $Montant): self
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->Motif;
    }

    public function setMotif(?string $Motif): self
    {
        $this->Motif = $Motif;

        return $this;
    }

    public function getDateExecution(): ?\DateTimeInterface
    {
        return $this->Date_Execution;
    }

    public function setDateExecution(\DateTimeInterface $Date_Execution): self
    {
        $this->Date_Execution = $Date_Execution;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->Account;
    }

    public function setAccount(?Account $Account): self
    {
        $this->Account = $Account;

        return $this;
    }

    public function getAccount2(): ?Account
    {
        return $this->Account_2;
    }

    public function setAccount2(?Account $Account_2): self
    {
        $this->Account_2 = $Account_2;

        return $this;
    }

    public function getDevise(): ?string
    {
        return $this->devise;
    }

    public function setDevise(string $devise): self
    {
        $this->devise = $devise;

        return $this;
    }
}
