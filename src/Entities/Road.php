<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "roads")]

class Road 
{

 #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "ID", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "name", length: 255)]
    private string $name;

    #[ORM\Column(name: "location", length: 255)]
    private string $location;

    #[ORM\Column(name: "salting_time", length: 255)]
    private string $saltingTime;

    #[ORM\OneToMany(targetEntity: RoadSaltingFrequency::class, mappedBy: "road")]
    private Collection $saltingFrequencies;

    public function __construct()
    {
        $this->saltingFrequencies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getSaltingTime(): string
    {
        return $this->saltingTime;
    }

    public function setSaltingTime(string $saltingTime): void
    {
        $this->saltingTime = $saltingTime;
    }

    /**
     * @return Collection<int, RoadSaltingFrequency>
     */
    public function getSaltingFrequencies(): Collection
    {
        return $this->saltingFrequencies;
    }

    public function addSaltingFrequency(RoadSaltingFrequency $saltingFrequency): void
    {
        if (!$this->saltingFrequencies->contains($saltingFrequency)) {
            $this->saltingFrequencies->add($saltingFrequency);
            $saltingFrequency->setRoad($this);
        }
    }

    public function removeSaltingFrequency(RoadSaltingFrequency $saltingFrequency): void
    {
        if ($this->saltingFrequencies->removeElement($saltingFrequency)) {
            if ($saltingFrequency->getRoad() === $this) {
                $saltingFrequency->setRoad();
            }
        }
    }

    /**
     * Get salting frequency for a specific temperature range
     */
    public function getFrequencyForTemp(int $tempMin, int $tempMax): ?int
    {
        foreach ($this->saltingFrequencies as $frequency) {
            if ($frequency->getTempMin() === $tempMin && $frequency->getTempMax() === $tempMax) {
                return $frequency->getSaltingFrequency();
            }
        }
        return null;
    }
}