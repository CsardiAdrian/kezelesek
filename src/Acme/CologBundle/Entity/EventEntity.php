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
     * @ORM\ManyToOne(targetEntity="\Acme\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="cosmeticianId", referencedColumnName="id")
     **/

    private $cosmeticianId;

    /**
     * @ORM\ManyToOne(targetEntity="treatments")
     * @ORM\JoinColumn(name="treatments_id", referencedColumnName="id")
     **/
    private $TreatmentsId;

    /**
     * @ORM\ManyToOne(targetEntity="\Acme\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="guser_id", referencedColumnName="id")
     **/

    private $guserId;

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
     * Set cosmeticianId
     *
     * @param string $cosmeticianId
     * @return EventEntity
     */
    public function setCosmeticianId($cosmeticianId)
    {
        $this->cosmeticianId = $cosmeticianId;

        return $this;
    }

    /**
     * Get cosmeticianId
     *
     * @return string
     */
    public function getCosmeticianId()
    {
        return $this->cosmeticianId;
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
     * Set guserId
     *
     * @param string $guserId
     * @return EventEntity
     */
    public function setGuserId($guserId)
    {
        $this->guserId = $guserId;

        return $this;
    }

    /**
     * Get guserId
     *
     * @return string 
     */
    public function getGuserId()
    {
        return $this->guserId;
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
