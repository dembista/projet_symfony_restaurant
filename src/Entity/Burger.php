<?php

namespace App\Entity;

use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
class Burger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    public $nom_burger;

    #[ORM\Column(type: 'integer')]
    public $prix;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $etat;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: Image::class)]
    private $images;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: Commande::class)]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'burg', targetEntity: Image::class)]
    private $imgs;

    #[ORM\OneToMany(mappedBy: 'bur', targetEntity: Image::class)]
    private $imags;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'burgers')]
    private $commands;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $type;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: Menu::class)]
    private $menus;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->imgs = new ArrayCollection();
        $this->imags = new ArrayCollection();
        $this->commands = new ArrayCollection();
        $this->menus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomBurger(): ?string
    {
        return $this->nom_burger;
    }

    public function setNomBurger(string $nom_burger): self
    {
        $this->nom_burger = $nom_burger;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

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

    /**
     * @return Collection<int, Image> , cascade={"persist"}
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setBurger($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getBurger() === $this) {
                $image->setBurger(null);
            }
        }

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
    //         $commande->setBurger($this);
    //     }

    //     return $this;
    // }

    // public function removeCommande(Commande $commande): self
    // {
    //     if ($this->commandes->removeElement($commande)) {
    //         // set the owning side to null (unless already changed)
    //         if ($commande->getBurger() === $this) {
    //             $commande->setBurger(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, Image>
     */
    public function getImgs(): Collection
    {
        return $this->imgs;
    }

    public function addImg(Image $img): self
    {
        if (!$this->imgs->contains($img)) {
            $this->imgs[] = $img;
            $img->setBurg($this);
        }

        return $this;
    }

    public function removeImg(Image $img): self
    {
        if ($this->imgs->removeElement($img)) {
            // set the owning side to null (unless already changed)
            if ($img->getBurg() === $this) {
                $img->setBurg(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImags(): Collection
    {
        return $this->imags;
    }

    public function addImag(Image $imag): self
    {
        if (!$this->imags->contains($imag)) {
            $this->imags[] = $imag;
            $imag->setBur($this);
        }

        return $this;
    }

    public function removeImag(Image $imag): self
    {
        if ($this->imags->removeElement($imag)) {
            // set the owning side to null (unless already changed)
            if ($imag->getBur() === $this) {
                $imag->setBur(null);
            }
        }

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
            $command->addBurger($this);
        }

        return $this;
    }

    public function removeCommand(Commande $command): self
    {
        if ($this->commands->removeElement($command)) {
            $command->removeBurger($this);
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

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setBurger($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getBurger() === $this) {
                $menu->setBurger(null);
            }
        }

        return $this;
    }
}
