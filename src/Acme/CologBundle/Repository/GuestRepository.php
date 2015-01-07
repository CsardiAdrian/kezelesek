<?php

namespace Acme\CologBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GuestRepository extends EntityRepository
{
    public function findguest($guests){
        return $this->getEntityManager()
            ->createQuery(
                '
                SELECT
                  *
                FROM
                  AcmeCologBundle:guest guest
                WHERE
                  guest.name = :name
                ORDER BY
                  guest.name DESC
                '
            )
            ->getResult();
    }
}