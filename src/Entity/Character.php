<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharacterRepository::class)
 * @ORM\Table(name="`character`")
 */
class Character
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $life;

    /**
     * @ORM\Column(type="integer")
     */
    private $attack;

    /**
     * @ORM\Column(type="integer")
     */
    private $shielding;

    /**
     * @ORM\OneToOne(targetEntity=Adventure::class, mappedBy="character")
     */
    private $adventure_relation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLife(): ?int
    {
        return $this->life;
    }

    public function setLife(int $life): self
    {
        $this->life = $life;

        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(int $attack): self
    {
        $this->attack = $attack;

        return $this;
    }

    public function getShielding(): ?int
    {
        return $this->shielding;
    }

    public function setShielding(int $shielding): self
    {
        $this->shielding = $shielding;

        return $this;
    }

    public function getAdventureRelation(): ?Adventure
    {
        return $this->adventure_relation;
    }

    public function setAdventureRelation(?Adventure $adventure_relation): self
    {
        // unset the owning side of the relation if necessary
        if ($adventure_relation === null && $this->adventure_relation !== null) {
            $this->adventure_relation->setCharacter(null);
        }

        // set the owning side of the relation if necessary
        if ($adventure_relation !== null && $adventure_relation->getCharacter() !== $this) {
            $adventure_relation->setCharacter($this);
        }

        $this->adventure_relation = $adventure_relation;

        return $this;
    }
}
