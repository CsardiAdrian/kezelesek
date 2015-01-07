<?php

namespace Acme\CologBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Acme\CologBundle\Entity\guest;
use Acme\CologBundle\Form\Type\GuestType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class GuestController extends Controller
{

//  List Function *****************************/
    public function guestAction()
    {
        $guest = new guest();

        $guest->setName('Kovács Rita')
            ->setPhone('06302367896')
            ->setEmail('krita@gmail.com')
        ;

        $repository = $this->getDoctrine()
            ->getRepository('AcmeCologBundle:guest');

        $guests = $repository->findAll();

        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->render('AcmeCologBundle:Default:guest.html.twig', array(
                'guests' => $guests
            ));
        }else{

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
    }

//  Add Function *****************************/
    public function addGuestAction(Request $request)
    {
        $guest = new guest();

        $guest->setName('Kovács Rita')
            ->setPhone('06302367896')
            ->setEmail('krita@gmail.com')
        ;

        $guestregform = $form = $this->createForm(new GuestType(), $guest, array(
            'action' => $this->generateUrl('_addGuest'),
            'method' => 'POST',
        ));

        $guestregform->handleRequest($request);

        if ($guestregform->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($guest);
            $em->flush();
            return $this->redirect($this->generateUrl('_guestSuccess'));
        }

        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->render('AcmeCologBundle:Default:addguest.html.twig', array(
                'guestregform' => $guestregform->createView(),
            ));
        }else{

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }


    }

//  Add Success Function *****************************/
    public function guestSuccessAction()
    {
        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->render('AcmeCologBundle:Default:guestRegistrationFormSuccess.html.twig');
        }else{

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

    }

//  Delete Function *****************************/
    public function deleteGuestAction()
    {
        $request = Request::createFromGlobals();
        $id = $getId = $request->query->get('id');

        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $guest = $em->getRepository('AcmeCologBundle:guest')->find(
                $id
            );

            if ($guest) {
//            exit(\Doctrine\Common\Util\Debug::dump( $guest));
                $em->remove($guest);
                $em->flush();
                return $this->redirect($this->generateUrl('_deleteGuestSuccess'));
            }
            else{
                throw new \Exception('Nem találom az elemet');
            }

        }
        else{
            throw new \Exception('Nincs átadva id');
        }


        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->redirect($this->generateUrl('_guest'));
        }else{

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
    }

//  Delete Success Function*****************************/
    public function deleteGuestSuccessAction()
    {

        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->render('AcmeCologBundle:Default:deleteGuestSuccess.html.twig');
        }else{

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

    }

//  Update Function *****************************/
    public function updateGuestAction(){
        $request = Request::createFromGlobals();
        $id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $guest = $em->getRepository('AcmeCologBundle:guest')->find($id);
        $guestregform = $this->createForm(new GuestType(), $guest);
        if ($request->getMethod() == 'POST') {
            $guestregform->bind($request);
            $id = $request->query->get('id');
            $name = $guestregform["name"]->getData();
            $email = $guestregform["email"]->getData();
            $phone = $guestregform['phone']->getData();
            $em = $this->getDoctrine()->getManager();
            $guest = $em->getRepository('AcmeCologBundle:guest')->find($id);
            $guest->setName($name);
            $guest->setEmail($email);
            $guest->setPhone($phone);
//            exit(\Doctrine\Common\Util\Debug::dump($id));
            $em->flush();
            return $this->redirect($this->generateUrl('_guest'));
        }
        return $this->render('AcmeCologBundle:Default:updateGuest.html.twig', array(
            'guestregform' => $guestregform->createView(),
            'id' => $id,
            'guest' => $guest
        ));
    }

}