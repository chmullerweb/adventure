<?php

namespace App\Entity;

use App\Repository\AdventureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdventureRepository::class)
 */
class Adventure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
      * @ORM\ManyToOne(targetEntity=Tile::class)
     */
    private $tile;

    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    public function __construct()
    {
        $this->tile = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTile(): ?Tile
    {
        return $this->tile;
    }

    public function setTile(?Tile $tile): self
    {
        $this->tile = $tile;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function addTile(Tile $tile): self
    {
        if (!$this->tile->contains($tile)) {
            $this->tile[] = $tile;
            $tile->setAdventure($this);
        }

        return $this;
    }

    public function removeTile(Tile $tile): self
    {
        if ($this->tile->removeElement($tile)) {
            // set the owning side to null (unless already changed)
            if ($tile->getAdventure() === $this) {
                $tile->setAdventure(null);
            }
        }

        return $this;
    }
}
