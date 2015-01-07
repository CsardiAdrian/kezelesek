<?php

namespace Acme\CologBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;

use Acme\CologBundle\Entity\user;
use Acme\CologBundle\Form\Type\UserType;

use Acme\CologBundle\Entity\treatments;
use Acme\CologBundle\Form\Type\TreatmentsType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            $treatments = new treatments();
            $treatments->setName('Mezopen arckezelés')
                ->setPrice('3200')
                ->setTime('30')
            ;

            $repository = $this->getDoctrine()->getRepository('AcmeCologBundle:treatments');
            /** @var $repository \Doctrine\ORM\EntityManager */

            $treatment = $repository->findAll();
            return $this->render('AcmeCologBundle:Default:index.html.twig', array(
                'treatment' => $treatment
            ));
        }else{

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
    }

    public function loginAction(){
        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->render('AcmeCologBundle:Default:index.html.twig');
        }else{

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
    }


}