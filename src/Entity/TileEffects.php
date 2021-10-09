<?php

namespace App\Entity;

use App\Repository\TileEffectsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TileEffectsRepository::class)
 */
class TileEffects
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
     * @ORM\Column(type="integer")
     */
    private $effect_value;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $effect_target;

    /**
     * @ORM\OneToMany(targetEntity=Tile::class, mappedBy="effects")
     */
    private $tile_relation;

    public function __construct()
    {
        $this->tile_relation = new ArrayCollection();
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

    public function getEffectValue(): ?int
    {
        return $this->effect_value;
    }

    public function setEffectValue(int $effect_value): self
    {
        $this->effect_value = $effect_value;

        return $this;
    }

    public function getEffectTarget(): ?string
    {
        return $this->effect_target;
    }

    public function setEffectTarget(string $effect_target): self
    {
        $this->effect_target = $effect_target;

        return $this;
    }

    /**
     * @return Collection|Tile[]
     */
    public function getTileRelation(): Collection
    {
        return $this->tile_relation;
    }

    public function addTileRelation(Tile $tileRelation): self
    {
        if (!$this->tile_relation->contains($tileRelation)) {
            $this->tile_relation[] = $tileRelation;
            $tileRelation->setEffects($this);
        }

        return $this;
    }

    public function removeTileRelation(Tile $tileRelation): self
    {
        if ($this->tile_relation->removeElement($tileRelation)) {
            // set the owning side to null (unless already changed)
            if ($tileRelation->getEffects() === $this) {
                $tileRelation->setEffects(null);
            }
        }

        return $this;
    }
}
