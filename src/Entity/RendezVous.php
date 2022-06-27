<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $dateHeure;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $duree;

    #[ORM\Column(type: 'string', length: 255)]
    private $confirmerRDV;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'rendezVouses')]
    private $patient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeure(): ?\DateTimeInterface
    {
        return $this->dateHeure;
    }

    public function setDateHeure(\DateTimeInterface $dateHeure): self
    {
        $this->dateHeure = $dateHeure;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getConfirmerRDV(): ?string
    {
        return $this->confirmerRDV;
    }

    public function setConfirmerRDV(string $confirmerRDV): self
    {
        $this->confirmerRDV = $confirmerRDV;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }
}
