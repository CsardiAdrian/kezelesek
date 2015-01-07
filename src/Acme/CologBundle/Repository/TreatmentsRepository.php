<?php

namespace Acme\CologBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TreatmentsRepository extends EntityRepository
{
    public function selectedById($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT treatments FROM AcmeCologBundle:treatments treatments WHERE treatments.id = :id'
            )
            ->setParameter('id', $id)
            ->getResult();
    }
}