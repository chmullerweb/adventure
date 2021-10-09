<?php

namespace App\Entity;

use App\Repository\TileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TileRepository::class)
 */
class Tile
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
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Monster::class, inversedBy="tile_relation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $monster;

    /**
     * @ORM\ManyToOne(targetEntity=TileEffects::class, inversedBy="tile_relation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $effects;

    /**
     * @ORM\OneToMany(targetEntity=Adventure::class, mappedBy="tile")
     */
    private $adventure_relation;

    public function __construct()
    {
        $this->adventure_relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMonster(): ?Monster
    {
        return $this->monster;
    }

    public function setMonster(?Monster $monster): self
    {
        $this->monster = $monster;

        return $this;
    }

    public function getEffects(): ?TileEffects
    {
        return $this->effects;
    }

    public function setEffects(?TileEffects $effects): self
    {
        $this->effects = $effects;

        return $this;
    }

    public function getAdventure(): ?Adventure
    {
        return $this->adventure;
    }

    public function setAdventure(?Adventure $adventure): self
    {
        $this->adventure = $adventure;

        return $this;
    }

    /**
     * @return Collection|Adventure[]
     */
    public function getAdventureRelation(): Collection
    {
        return $this->adventure_relation;
    }

    public function addAdventureRelation(Adventure $adventureRelation): self
    {
        if (!$this->adventure_relation->contains($adventureRelation)) {
            $this->adventure_relation[] = $adventureRelation;
            $adventureRelation->setTile($this);
        }

        return $this;
    }

    public function removeAdventureRelation(Adventure $adventureRelation): self
    {
        if ($this->adventure_relation->removeElement($adventureRelation)) {
            // set the owning side to null (unless already changed)
            if ($adventureRelation->getTile() === $this) {
                $adventureRelation->setTile(null);
            }
        }

        return $this;
    }
}
