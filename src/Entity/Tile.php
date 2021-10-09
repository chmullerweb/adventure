<?php

namespace App\Entity;

use App\Repository\TileRepository;
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
}
