<?php

namespace Zizoo\BoatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Zizoo\BoatBundle\Entity\BoatRepository")
 * @ORM\Table(name="boat")
 */
class Boat
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $title;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(type="string")
     */
    protected $city;

    /**
     * @ORM\Column(type="string")
     */
    protected $address;

    /**
     * @ORM\Column(type="string")
     */
    protected $brand;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $model;

    /**
     * @ORM\Column(type="integer")
     */
    protected $length;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $cabins;
    
    /**
     * @ORM\Column(type="integer", nullable=TRUE)
     */
    protected $bathrooms;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $nr_guests;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $status;
       
    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="boat")
     */
    protected $image;
    
    /**
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="boat")
     */
    protected $reservation;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    public function __construct()
    {
        $this->image = new ArrayCollection();
        $this->reservation = new ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Boat
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return Boat
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Boat
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Boat
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Boat
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set brand
     *
     * @param string $brand
     * @return Boat
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    
        return $this;
    }

    /**
     * Get brand
     *
     * @return string 
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set model
     *
     * @param string $model
     * @return Boat
     */
    public function setModel($model)
    {
        $this->model = $model;
    
        return $this;
    }

    /**
     * Get model
     *
     * @return string 
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set length
     *
     * @param integer $length
     * @return Boat
     */
    public function setLength($length)
    {
        $this->length = $length;
    
        return $this;
    }

    /**
     * Get length
     *
     * @return integer 
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set cabins
     *
     * @param integer $cabins
     * @return Boat
     */
    public function setCabins($cabins)
    {
        $this->cabins = $cabins;
    
        return $this;
    }

    /**
     * Get cabins
     *
     * @return integer 
     */
    public function getCabins()
    {
        return $this->cabins;
    }

    /**
     * Set bathrooms
     *
     * @param integer $bathrooms
     * @return Boat
     */
    public function setBathrooms($bathrooms)
    {
        $this->bathrooms = $bathrooms;
    
        return $this;
    }

    /**
     * Get bathrooms
     *
     * @return integer 
     */
    public function getBathrooms()
    {
        return $this->bathrooms;
    }

    /**
     * Set nr_guests
     *
     * @param integer $nrGuests
     * @return Boat
     */
    public function setNrGuests($nrGuests)
    {
        $this->nr_guests = $nrGuests;
    
        return $this;
    }

    /**
     * Get nr_guests
     *
     * @return integer 
     */
    public function getNrGuests()
    {
        return $this->nr_guests;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Boat
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Boat
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Boat
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add reservation
     *
     * @param \Zizoo\BoatBundle\Entity\Reservation $reservation
     * @return Boat
     */
    public function addReservation(\Zizoo\BoatBundle\Entity\Reservation $reservation)
    {
        $this->reservation[] = $reservation;
    
        return $this;
    }

    /**
     * Remove reservation
     *
     * @param \Zizoo\BoatBundle\Entity\Reservation $reservation
     */
    public function removeReservation(\Zizoo\BoatBundle\Entity\Reservation $reservation)
    {
        $this->reservation->removeElement($reservation);
    }

    /**
     * Get reservation
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReservation()
    {
        return $this->reservation;
    }

    /**
     * Add image
     *
     * @param \Zizoo\BoatBundle\Entity\Image $image
     * @return Boat
     */
    public function addImage(\Zizoo\BoatBundle\Entity\Image $image)
    {
        $this->image[] = $image;
    
        return $this;
    }

    /**
     * Remove image
     *
     * @param \Zizoo\BoatBundle\Entity\Image $image
     */
    public function removeImage(\Zizoo\BoatBundle\Entity\Image $image)
    {
        $this->image->removeElement($image);
    }

    /**
     * Get image
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImage()
    {
        return $this->image;
    }
}