<?php

namespace App\Entity;

use App\Repository\RentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RentRepository::class)]
#[ORM\Table('deliverer_vehicle')]
class Rent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Deliverer::class, inversedBy: 'rents')]
    #[ORM\JoinColumn(nullable: false)]
    private $deliverer;

    #[ORM\ManyToOne(targetEntity: Vehicle::class, inversedBy: 'rents')]
    #[ORM\JoinColumn(nullable: false)]
    private $vehicle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeliverer(): ?Deliverer
    {
        return $this->deliverer;
    }

    public function setDeliverer(?Deliverer $deliverer): self
    {
        $this->deliverer = $deliverer;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }
}
