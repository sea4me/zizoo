<?php

namespace Zizoo\BoatBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zizoo\BoatBundle\Entity\Reservation;
use Zizoo\BoatBundle\Entity\Boat;

class ReservationFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $reservation = new Reservation();
        $reservation->setCheckIn(new \DateTime());
        $reservation->setCheckOut(new \DateTime());
        $reservation->setBoat($manager->merge($this->getReference('boat-1')));
        $manager->persist($reservation);

        $manager->flush();

    }

    public function getOrder()
    {
        return 2;
    }

}