<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom_image;

    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'images')]
    private $burger;

    #[ORM\ManyToOne(targetEntity: Complement::class, inversedBy: 'images')]
    private $complement;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'images')]
    private $menu;

    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'imgs')]
    private $burg;

    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'imags')]
    private $bur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomImage(): ?string
    {
        return $this->nom_image;
    }

    public function setNomImage(string $nom_image): self
    {
        $this->nom_image = $nom_image;

        return $this;
    }

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

        return $this;
    }

    public function getComplement(): ?Complement
    {
        return $this->complement;
    }

    public function setComplement(?Complement $complement): self
    {
        $this->complement = $complement;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getBurg(): ?Burger
    {
        return $this->burg;
    }

    public function setBurg(?Burger $burg): self
    {
        $this->burg = $burg;

        return $this;
    }

    public function getBur(): ?Burger
    {
        return $this->bur;
    }

    public function setBur(?Burger $bur): self
    {
        $this->bur = $bur;

        return $this;
    }
}
