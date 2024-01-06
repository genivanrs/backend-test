<?php

namespace App\Entity;

use App\Repository\MovementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovementRepository::class)]
class Movement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\OneToMany(mappedBy: 'movement', targetEntity: Investment::class)]
    private Collection $investment;

    #[ORM\Column(length: 255, enumType: Type::class)]
    private Type $type;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->investment = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Investment>
     */
    public function getInvestment(): Collection
    {
        return $this->investment;
    }

    public function addInvestment(Investment $investment): static
    {
        if (!$this->investment->contains($investment)) {
            $this->investment->add($investment);
            $investment->setMovement($this);
        }

        return $this;
    }    

    public function getType(): Type
    {
        return $this->type;
    }

    public function setType(Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
