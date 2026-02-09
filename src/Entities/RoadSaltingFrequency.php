<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "road_salting_frequency")]
class RoadSaltingFrequency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "ID", type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Road::class, inversedBy: "saltingFrequencies")]
    #[ORM\JoinColumn(name: "road_id", referencedColumnName: "ID", nullable: false)]
    private ?Road $road = null;

    #[ORM\Column(name: "temp_min", type: "integer")]
    private int $tempMin;

    #[ORM\Column(name: "temp_max", type: "integer")]
    private int $tempMax;

    #[ORM\Column(name: "salting_frequency", type: "integer")]
    private int $saltingFrequency;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoad(): ?Road
    {
        return $this->road;
    }

    public function setRoad(?Road $road = null): void
    {
        $this->road = $road;
    }

    public function getTempMin(): int
    {
        return $this->tempMin;
    }

    public function setTempMin(int $tempMin): void
    {
        $this->tempMin = $tempMin;
    }

    public function getTempMax(): int
    {
        return $this->tempMax;
    }

    public function setTempMax(int $tempMax): void
    {
        $this->tempMax = $tempMax;
    }

    public function getSaltingFrequency(): int
    {
        return $this->saltingFrequency;
    }

    public function setSaltingFrequency(int $saltingFrequency): void
    {
        $this->saltingFrequency = $saltingFrequency;
    }
}
