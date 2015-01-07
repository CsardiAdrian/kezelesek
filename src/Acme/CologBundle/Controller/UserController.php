<?php

namespace Acme\CologBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;

use Acme\CologBundle\Entity\user;
use Acme\CologBundle\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends Controller
{

    public function registrationAction(Request $request)
    {
        $user = new user();

        $user->setName('Csárdi Adrián')
            ->setNickName('Enddy')
            ->setEmail('support@aceimprt.hu')
            ->setPassword(351288)
            ->setAdmin(0)
        ;


        $regform = $form = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('_registration'),
            'method' => 'POST',
        ));

        $regform->handleRequest($request);

        if ($regform->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirect($this->generateUrl('_registration_success'));
        }

        return $this->render('AcmeCologBundle:Default:registration.html.twig', array(
            'regform' => $regform->createView(),
        ));


//        $repository = $this->getDoctrine()
//            ->getRepository('AcmeCologBundle:user');
//
//        $user = $repository->findall();

    }

    public function registrationSuccessAction()
    {

        return $this->render('AcmeCologBundle:Default:registration-success.html.twig');

    }

}