<?php

namespace Acme\CologBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventsEntity
 *
 * @ORM\Table(name="events")
 * @ORM\Entity
 */
class EventEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="treatments")
     * @ORM\JoinColumn(name="treatments_id", referencedColumnName="id")
     **/
    private $TreatmentsId;

    /**
     * @ORM\ManyToOne(targetEntity="guest")
     * @ORM\JoinColumn(name="guest_id", referencedColumnName="id")
     **/

    private $guestId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDatetime", type="datetime")
     */
    private $startDatetime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDatetime", type="datetime")
     */
    private $endDatetime;

    /**
     * @var boolean
     *
     * @ORM\Column(name="allDay", type="boolean")
     */
    private $allDay;

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
     * @return EventEntity
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
     * Set TreatmentsId
     *
     * @param string $TreatmentsId
     * @return EventEntity
     */
    public function setTreatmentsId($TreatmentsId)
    {
        $this->TreatmentsId = $TreatmentsId;

        return $this;
    }

    /**
     * Get TreatmentsId
     *
     * @return string
     */
    public function getTreatmentsId()
    {
        return $this->TreatmentsId;
    }

    /**
     * Set guestId
     *
     * @param string $guestId
     * @return EventEntity
     */
    public function setGuestId($guestId)
    {
        $this->guestId = $guestId;

        return $this;
    }

    /**
     * Get guestId
     *
     * @return string 
     */
    public function getGuestId()
    {
        return $this->guestId;
    }

    /**
     * Set startDatetime
     *
     * @param \DateTime $startDatetime
     * @return EventEntity
     */
    public function setStartDatetime($startDatetime)
    {
        $this->startDatetime = $startDatetime;

        return $this;
    }

    /**
     * Get startDatetime
     *
     * @return \DateTime 
     */
    public function getStartDatetime()
    {
        return $this->startDatetime;
    }

    /**
     * Set endDatetime
     *
     * @param \DateTime $endDatetime
     * @return EventEntity
     */
    public function setEndDatetime($endDatetime)
    {
        $this->endDatetime = $endDatetime;

        return $this;
    }

    /**
     * Get endDatetime
     *
     * @return \DateTime 
     */
    public function getEndDatetime()
    {
        return $this->endDatetime;
    }

    /**
     * Set allDay
     *
     * @param boolean $allDay
     * @return EventEntity
     */
    public function setAllDay($allDay)
    {
        $this->allDay = $allDay;

        return $this;
    }

    /**
     * Get allDay
     *
     * @return boolean 
     */
    public function getAllDay()
    {
        return $this->allDay;
    }
}
