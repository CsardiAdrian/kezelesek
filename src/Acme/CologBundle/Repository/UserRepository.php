<?php

namespace Acme\CologBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
//    public function selectedById($cid)
//    {
//        return $this->getEntityManager()
//            ->createQuery(
//                'SELECT users FROM UserBundle:Users Users WHERE users.id = :id AND users.cosmetician = TRUE'
//            )
//            ->setParameter('id', $cid)
//            ->getResult();
//    }
}

