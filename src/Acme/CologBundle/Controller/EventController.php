<?php

namespace Acme\CologBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Acme\CologBundle\Entity\EventEntity;
use Acme\CologBundle\Entity\treatments;
use Acme\UserBundle\Entity\User;
use Acme\CologBundle\Form\Type\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EventController extends Controller
{

//  List Function *****************************/
    public function listEventsAction()
    {
        $repository = $this->getDoctrine()->getRepository('AcmeCologBundle:EventEntity');
        /** @var $repository \Doctrine\ORM\EntityManager */
        $events = $repository->findAll();
        $profiluser = $this->getUser();

        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
//        exit(\Doctrine\Common\Util\Debug::dump($profiluser));
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->render('AcmeCologBundle:Default:events.html.twig', array(
                'user' => $profiluser,
                'events' => $events
            ));
        } else {

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

    }

//  Add Function *****************************/
    public function addEventAction(Request $request)
    {
        $treatment = $this->getDoctrine()->getRepository('AcmeCologBundle:treatments')->findAll();
        $user = $this->getDoctrine()->getRepository('UserBundle:user')->findAll();
        $cosmetician = $this->getDoctrine()->getRepository('UserBundle:user')->findBy(
            array('cosmetician' => true)
        );

        $event = new EventEntity();
        $event->setAllday(0);

        $addEventForm = $form = $this->createForm(new EventType(), $event, array(
            'action' => $this->generateUrl('_addEvent'),
            'method' => 'POST',
        ));

        $addEventForm->handleRequest($request);

        if ($addEventForm->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $start = $addEventForm['startDatetime']->getData();
            $event->setStartDatetime(new \DateTime($start));

            $end = $addEventForm['startDatetime']->getData();
            $event->setEndDatetime(new \DateTime($end));

            $tid = $_POST['treatment'];
            $treatmentId = $this->getDoctrine()->getRepository('AcmeCologBundle:treatments')->find($tid);
            $event->setTreatmentsId($treatmentId);

            $uid = $_POST['user'];
            $guserId = $this->getDoctrine()->getRepository('UserBundle:User')->find($uid);
            $event->setGuserId($guserId);

            $cid = $_POST['cosmetician'];
            $cosmeticianId = $this->getDoctrine()->getRepository('UserBundle:User')->find($cid);
            $event->setCosmeticianId($cosmeticianId);

            $em->persist($event);
//          exit(\Doctrine\Common\Util\Debug::dump($event));
            $em->flush();
            return $this->redirect($this->generateUrl('_addEventSuccess'));
        }

        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            $profiluser = $this->getUser();
            return $this->render('AcmeCologBundle:Default:addEvent.html.twig', array(
                'addEventForm' => $addEventForm->createView(),
                'users' => $user,
                'user' => $profiluser,
                'treatment' => $treatment,
                'cosmetician' => $cosmetician
            ));
        } else {

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }


    }

//  Add Success Function *****************************/
    public function addEventSuccessAction()
    {
        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            $user = $this->getUser();
            return $this->render('AcmeCologBundle:Default:addEventFormSuccess.html.twig', array(
                'user' => $user,
            ));
        } else {

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

    }

//  Delete Function *****************************/
    public function deleteEventAction()
    {
        $request = Request::createFromGlobals();
        $id = $getId = $request->query->get('id');

        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $event = $em->getRepository('AcmeCologBundle:EventEntity')->find(
                $id
            );

//            exit(\Doctrine\Common\Util\Debug::dump($event));
            if ($event) {
                $em->remove($event);
                $em->flush();
                $user = $this->getUser();
                return $this->render('AcmeCologBundle:Default:deleteEventSuccess.html.twig', array(
                    'user' => $user,
                ));
            } else {
                throw new \Exception('Nem találom az elemet');
            }

        } else {
            throw new \Exception('Nincs átadva id');
        }


        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->redirect($this->generateUrl('_events'));
        } else {

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
    }

//  Delete Success Function*****************************/
    public function deleteEventSuccessAction()
    {

        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->render('AcmeCologBundle:Default:deleteEventSuccess.html.twig');
        } else {

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

    }

////  Update Function *****************************/
    public function updateEventAction()
    {
        $request = Request::createFromGlobals();
        $id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('AcmeCologBundle:EventEntity')->find($id);
        $updateEventForm = $this->createForm(new GuestType(), $event);
        if ($request->getMethod() == 'POST') {
            $updateEventForm->bind($request);
            $id = $request->query->get('id');
            $name = $updateEventForm["name"]->getData();
            $email = $updateEventForm["email"]->getData();
            $phone = $updateEventForm['phone']->getData();
            $em = $this->getDoctrine()->getManager();
            $event = $em->getRepository('AcmeCologBundle:EventEntity')->find($id);
            $event->setUsername($name);
            $event->setEmail($email);
            $event->setPhone($phone);
//            exit(\Doctrine\Common\Util\Debug::dump($id));
            $em->flush();
            return $this->redirect($this->generateUrl('_events'));
        }
        return $this->render('AcmeCologBundle:Default:updateEvent.html.twig', array(
            'updateEventForm' => $updateEventForm->createView(),
            'id' => $id,
            'event' => $event
        ));
    }

    public function sendMailAction()
    {

        $date = new \DateTime('now');
        $date->sub(new \DateInterval('P1D'));
        $datetime = $date->format('Y-m-d h:m:s') . "\n";
        exit(\Doctrine\Common\Util\Debug::dump($datetime));

        $repository = $this->getDoctrine()->getRepository('AcmeCologBundle:EventEntity');
        /** @var $repository \Doctrine\ORM\EntityManager */
        $events = $repository->createQueryBuilder('e')
            ->where('e.startDatetime = :startDatetime')
            ->setParameter('startDatetime', '19.99')
            ->getQuery();

        $event = $events->getResult();


        $message = \Swift_Message::newInstance()// we create a new instance of the Swift_Message class
        ->setSubject('Wellness kozmetika időpont emlékeztető')// we configure the title
        ->setFrom('support@aceimport.hu')// we configure the sender
        ->setTo('cs.adrian8@gmail.com')// we configure the recipient
        ->setBody($this->renderView('AcmeCologBundle:Default:email.txt.twig', array('name' => 'Adrián')))// and we pass the $name variable to the text template which serves as a body of the message
        ;
        $this->get('mailer')->send($message);     // then we send the message.

        return $this->redirect($this->generateUrl('_events'));
    }

}