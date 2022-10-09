<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\Column(length: 100)]
    private ?string $ref = null;

    #[ORM\Column(length: 255)]
    private ?string $tilte = null;

    public function getRef(): ?string
    {
        return $this->ref;
    }
    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getTilte(): ?string
    {
        return $this->tilte;
    }

    public function setTilte(string $tilte): self
    {
        $this->tilte = $tilte;

        return $this;
    }

}
