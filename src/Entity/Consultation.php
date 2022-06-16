<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $Contenu;

    #[ORM\Column(type: 'date')]
    private $DateCons;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->Contenu;
    }

    public function setContenu(string $Contenu): self
    {
        $this->Contenu = $Contenu;

        return $this;
    }

    public function getDateCons(): ?\DateTimeInterface
    {
        return $this->DateCons;
    }

    public function setDateCons(\DateTimeInterface $DateCons): self
    {
        $this->DateCons = $DateCons;

        return $this;
    }
}
