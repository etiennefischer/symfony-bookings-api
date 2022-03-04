<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[UniqueEntity(
    fields: ['bookedAt', 'spot'],
    message: 'Spot unavailable for this date',
)]
#[UniqueEntity(
    fields: ['bookedAt', 'customer'],
    message: 'Customer already booked for this date',
)]
#[UniqueEntity(
    fields: ['weekNumber', 'customer'],
    message: 'Customer already booked for this week',
)]

#[ApiResource]

class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'datetime')]
    #[Assert\GreaterThan('today'), NotBlank]
    public ?\DateTimeInterface $bookedAt;

    #[ORM\Column(type: 'integer')]
    private ?int $weekNumber;


    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private $customer;

    #[ORM\ManyToOne(targetEntity: Spot::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private $spot;

    public function __construct()
    {
        $this->weekNumber = 0;

    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookedAt(): ?\DateTimeInterface
    {
        return $this->bookedAt;
    }

    public function setBookedAt(\DateTimeInterface $bookedAt): self
    {
        $this->bookedAt = $bookedAt;

        return $this;
    }

    public function getWeekNumber(): ?int
    {
        return $this->weekNumber;
    }


    public function setWeekNumber(?int $weekNumber): self
    {
       $this->weekNumber = $weekNumber;

       return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getSpot(): ?Spot
    {
        return $this->spot;
    }

    public function setSpot(?Spot $spot): self
    {
        $this->spot = $spot;

        return $this;
    }
}
