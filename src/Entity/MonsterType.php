<?php

namespace App\Entity;

use App\Repository\MonsterTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MonsterRepository::class)
 */
class MonsterType
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
     * @ORM\OneToMany(targetEntity=Monster::class, mappedBy="type")
     */
    private $monster_relation;

    public function __construct()
    {
        $this->monster_relation = new ArrayCollection();
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

    /**
     * @return Collection|Tile[]
     */
    public function getMonsterRelation(): Collection
    {
        return $this->monster_relation;
    }

    public function addMonsterRelation(Monster $monsterRelation): self
    {
        if (!$this->monster_relation->contains($monsterRelation)) {
            $this->monster_relation[] = $monsterRelation;
            $monsterRelation->setMonster($this);
        }

        return $this;
    }

    public function removeMonsterRelation(Monster $monsterRelation): self
    {
        if ($this->monster_relation->removeElement($monsterRelation)) {
            // set the owning side to null (unless already changed)
            if ($monsterRelation->getMonster() === $this) {
                $monsterRelation->setMonster(null);
            }
        }

        return $this;
    }
}
