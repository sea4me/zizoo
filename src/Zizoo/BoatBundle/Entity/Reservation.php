<?php
namespace Zizoo\BoatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Zizoo\BoatBundle\Entity\ReservationRepository")
 * @ORM\Table(name="reservation")
 * @ORM\HasLifecycleCallbacks()
 */
class Reservation
{
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Boat", inversedBy="reservation")
     * @ORM\JoinColumn(name="boat_id", referencedColumnName="id")
     */
    protected $boat;
        
    /**
     * @ORM\Column(type="datetime")
     */
    protected $check_in;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $check_out;

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
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
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
     * Set check_in
     *
     * @param \DateTime $checkIn
     * @return Reservation
     */
    public function setCheckIn($checkIn)
    {
        $this->check_in = $checkIn;
    
        return $this;
    }

    /**
     * Get check_in
     *
     * @return \DateTime 
     */
    public function getCheckIn()
    {
        return $this->check_in;
    }

    /**
     * Set check_out
     *
     * @param \DateTime $checkOut
     * @return Reservation
     */
    public function setCheckOut($checkOut)
    {
        $this->check_out = $checkOut;
    
        return $this;
    }

    /**
     * Get check_out
     *
     * @return \DateTime 
     */
    public function getCheckOut()
    {
        return $this->check_out;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Reservation
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
     * @return Reservation
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
     * Set boat
     *
     * @param \Zizoo\BoatBundle\Entity\Boat $boat
     * @return Reservation
     */
    public function setBoat(\Zizoo\BoatBundle\Entity\Boat $boat = null)
    {
        $this->boat = $boat;
    
        return $this;
    }

    /**
     * Get boat
     *
     * @return \Zizoo\BoatBundle\Entity\Boat 
     */
    public function getBoat()
    {
        return $this->boat;
    }
}