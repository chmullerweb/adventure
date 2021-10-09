<?php

namespace App\Entity;

use App\Repository\MonsterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MonsterRepository::class)
 */
class Monster
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=MonsterType::class)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Tile::class, mappedBy="monster")
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

    public function getType(): ?MonsterType
    {
        return $this->type;
    }

    public function setType(?MonsterType $type): self
    {
        $this->type = $type;

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
            $tileRelation->setMonster($this);
        }

        return $this;
    }

    public function removeTileRelation(Tile $tileRelation): self
    {
        if ($this->tile_relation->removeElement($tileRelation)) {
            // set the owning side to null (unless already changed)
            if ($tileRelation->getMonster() === $this) {
                $tileRelation->setMonster(null);
            }
        }

        return $this;
    }
}
