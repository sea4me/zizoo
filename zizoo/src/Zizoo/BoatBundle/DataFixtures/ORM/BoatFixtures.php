<?php

namespace Zizoo\BoatBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zizoo\BoatBundle\Entity\Boat;

class BoatFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $boat1 = new Boat();
        $boat1->setName('Sandali');
        $boat1->setTitle('The Ocean Explorer');
        $boat1->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis, justo mauris lacinia libero, non facilisis purus ipsum non mi. Aliquam sollicitudin, augue id vestibulum iaculis, sem lectus convallis nunc, vel scelerisque lorem tortor ac nunc. Donec pharetra eleifend enim vel porta.');
        $boat1->setCity('Krk');
        $boat1->setAddress('Krk Marina 48');
        $boat1->setBrand('Seasy');
        $boat1->setModel('911');
        $boat1->setLength('5');
        $boat1->setCabins('6');
        $boat1->setNrGuests('12');
        $boat1->setStatus('0');
        $boat1->setCreated(new \DateTime());
        $boat1->setUpdated($boat1->getCreated());
        $manager->persist($boat1);
        
        $boat2 = new Boat();
        $boat2->setName('Infinity');
        $boat2->setTitle('Forever Wherever');
        $boat2->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis, justo mauris lacinia libero, non facilisis purus ipsum non mi. Aliquam sollicitudin, augue id vestibulum iaculis, sem lectus convallis nunc, vel scelerisque lorem tortor ac nunc. Donec pharetra eleifend enim vel porta.');
        $boat2->setCity('Alicante');
        $boat2->setAddress('Alicante Marina 84');
        $boat2->setBrand('Floats');
        $boat2->setModel('919');
        $boat2->setLength('12');
        $boat2->setCabins('5');
        $boat2->setNrGuests('11');
        $boat2->setStatus('1');
        $boat2->setCreated(new \DateTime());
        $boat2->setUpdated($boat2->getCreated());
        $manager->persist($boat2);

        $manager->flush();

        $this->addReference('boat-1', $boat1);
        $this->addReference('boat-2', $boat2);
    }

    public function getOrder()
    {
        return 1;
    }

}