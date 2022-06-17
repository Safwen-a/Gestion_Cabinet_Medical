<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
class Medecin extends Person
{
    #[ORM\Column(type: 'string', length: 255)]
    private $specialite;

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }
}
