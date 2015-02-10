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
        $securityContext = $this->container->get('security.context');
        if($securityContext->isGranted('ROLE_SUPER_ADMIN')){
            $request = Request::createFromGlobals();
            $id = $request->query->get('id');
            $em = $this->getDoctrine()->getManager();
            $users = $em->getRepository('UserBundle:User')->find($id);

            $user = $this->getUser();
            if ($request->getMethod() == 'POST') {

                $id = $request->query->get('id');
                $username = $_POST['username'];
                $email = $_POST['email'];
                $enabled = $_POST['enabled'];
                $cosmetician = $_POST['cosmetician'];
                $password = $_POST['password'];
                $em = $this->getDoctrine()->getManager();
                $users = $em->getRepository('UserBundle:User')->find($id);
                $users->setUsername($username);
                $users->setEmail($email);
                $users->setEnabled($enabled);
                $users->setCosmetician($cosmetician);
                $users->setPlainPassword($password);
//                exit(\Doctrine\Common\Util\Debug::dump($users));
                $em->flush();
                return $this->redirect($this->generateUrl('_users'));
        }
            return $this->render('AcmeCologBundle:Default:editUsers.html.twig', array(
                'id' => $id,
                'user' => $user,
                'users' => $users,
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