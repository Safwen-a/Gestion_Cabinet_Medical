<?php

namespace App\Entity;

use App\Repository\AssistantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssistantRepository::class)]
class Assistant extends Person
{
    #[ORM\Column(type: 'json')]
    private $privilege;

    public function getPrivilege(): ?enum
    {
        return $this->privilege;
    }

    public function setPrivilege(enum $privilege): self
    {
        $this->privilege = $privilege;

        return $this;
    }
}
