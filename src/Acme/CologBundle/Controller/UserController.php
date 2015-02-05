<?php

namespace Acme\CologBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;

use FOS\UserBundle\FOSUserEvents;
use Acme\UserBundle\Entity\User;
use Acme\CologBundle\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends Controller
{
    //  List Function *****************************/
    public function listUsersAction()
    {
        $repository = $this->getDoctrine()->getRepository('UserBundle:User');
        /** @var $repository \Doctrine\ORM\EntityManager */

        $users = $repository->findAll();
        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('ROLE_SUPER_ADMIN')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            $user = $this->getUser();
            return $this->render('AcmeCologBundle:Default:users.html.twig', array(
                'users' => $users,
                'user' => $user
            ));
        }else{

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
    }

//  Edit Function *****************************/
    public function editUsersAction()
    {
        $repository = $this->getDoctrine()->getRepository('UserBundle:User');
        /** @var $repository \Doctrine\ORM\EntityManager */

        $users = $repository->findAll();
        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('ROLE_SUPER_ADMIN')) {
                $request = Request::createFromGlobals();
                $username = $request->request->get('username');
                $email = $request->request->get('email');
                $enabled = $request->request->get('enabled');
                $cosmetician = $request->request->get('cosmetician');
                $em = $this->getDoctrine()->getManager();
                $usersedit = $em->getRepository('UserBundle:User')->find(1);
//            exit(\Doctrine\Common\Util\Debug::dump($usersedit));
            $usersedit->setUsername($username);
            $usersedit->setEmail($email);
            $usersedit->setEnabled($enabled);
            $usersedit->setCosmetician($cosmetician);
                $em->flush();

            $user = $this->getUser();
            return $this->render('AcmeCologBundle:Default:editUsers.html.twig', array(
                'users' => $users,
                'user' => $user
            ));
        }else{

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

    }

    public function registrationAction(Request $request)
    {
        $user = new user();
//
//        $user->setName('Csárdi Adrián')
//            ->setNickName('Enddy')
//            ->setEmail('support@aceimprt.hu')
//            ->setPassword(351288)
//            ->setAdmin(0)
//        ;


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