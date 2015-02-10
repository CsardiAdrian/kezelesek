<?php
// src/Acme/CologBundle/EventListener/CalendarEventListener.php

namespace Acme\CologBundle\EventListener;

use ADesigns\CalendarBundle\Event\CalendarEvent;
use ADesigns\CalendarBundle\Entity\EventEntity;
use Doctrine\ORM\EntityManager;

class CalendarEventListener
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadEvents(CalendarEvent $calendarEvent)
    {
        $startDate = $calendarEvent->getStartDatetime();
        $endDate = $calendarEvent->getEndDatetime();

        // The original request so you can get filters from the calendar
        // Use the filter in your query for example

        $request = $calendarEvent->getRequest();
        $filter = $request->get('filter');


        // load events using your custom logic here,
        // for instance, retrieving events from a repository

        $companyEvents = $this->entityManager->getRepository('AcmeCologBundle:EventEntity')
            ->createQueryBuilder('company_events')
            ->where('company_events.startDatetime BETWEEN :startDatetime and :endDatetime')
            ->setParameter('startDatetime', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('endDatetime', $endDate->format('Y-m-d H:i:s'))
            ->getQuery()->getResult();

        // $companyEvents and $companyEvent in this example
        // represent entities from your database, NOT instances of EventEntity
        // within this bundle.
        //
        // Create EventEntity instances and populate it's properties with data
        // from your own entities/database values.

        foreach($companyEvents as $companyEvent) {

            // create an event with a start/end time, or an all day event
            if ($companyEvent->getAllDay() === false) {
                $eventEntity = new EventEntity($companyEvent->getCosmeticianId(), $companyEvent->getStartDatetime(), $companyEvent->getEndDatetime());
            } else {
                $eventEntity = new EventEntity($companyEvent->getCosmeticianId(), $companyEvent->getStartDatetime(), null, true);
            }

            //optional calendar event settings
            $eventEntity->getAllDay(); // default is false, set to true if this is an all day event
            $eventEntity->getTreatmentsId(); // url to send user to when event label is clicked
            $eventEntity->getGuestId(); // a custom class you may want to apply to event labels

            //finally, add the event to the CalendarEvent for displaying on the calendar
            $calendarEvent->addEvent($eventEntity);
        }
    }
}