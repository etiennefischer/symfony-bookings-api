<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;

class BookingDataPersister implements DataPersisterInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function supports($data): bool
    {
        return $data instanceof Booking;
    }

    /**
     * @param Booking $data
     *
     * @return void
     */
    public function persist($data)
    {
        $bookedAt = $data->getBookedAt();

        $data->setWeekNumber(idate('W', strtotime($bookedAt->format('Y-m-d H:i:s'))));

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }

}