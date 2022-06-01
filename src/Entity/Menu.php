<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    public $nom_menu;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $etat;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $prix;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: Image::class)]
    private $images;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: Commande::class)]
    private $commandes;

    #[ORM\ManyToOne(targetEntity: Burger::class)]
    private $burgers;

    #[ORM\ManyToOne(targetEntity: Complement::class, inversedBy: 'menus')]
    private $complements;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'menus')]
    private $commands;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $type;

    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menus')]
    private $burger;

    #[ORM\ManyToOne(targetEntity: Complement::class, inversedBy: 'menu')]
    private $complement;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->commands = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMenu(): ?string
    {
        return $this->nom_menu;
    }

    public function setNomMenu(string $nom_menu): self
    {
        $this->nom_menu = $nom_menu;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setMenu($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getMenu() === $this) {
                $image->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    // public function addCommande(Commande $commande): self
    // {
    //     if (!$this->commandes->contains($commande)) {
    //         $this->commandes[] = $commande;
    //         $commande->setMenu($this);
    //     }

    //     return $this;
    // }

    // public function removeCommande(Commande $commande): self
    // {
    //     if ($this->commandes->removeElement($commande)) {
    //         // set the owning side to null (unless already changed)
    //         if ($commande->getMenu() === $this) {
    //             $commande->setMenu(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getBurgers(): ?Burger
    {
        return $this->burgers;
    }

    public function setBurgers(?Burger $burgers): self
    {
        $this->burgers = $burgers;

        return $this;
    }

    public function getComplements(): ?Complement
    {
        return $this->complements;
    }

    public function setComplements(?Complement $complements): self
    {
        $this->complements = $complements;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommands(): Collection
    {
        return $this->commands;
    }

    public function addCommand(Commande $command): self
    {
        if (!$this->commands->contains($command)) {
            $this->commands[] = $command;
            $command->addMenu($this);
        }

        return $this;
    }

    public function removeCommand(Commande $command): self
    {
        if ($this->commands->removeElement($command)) {
            $command->removeMenu($this);
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

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
}
