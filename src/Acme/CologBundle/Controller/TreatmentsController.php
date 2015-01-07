<?php

namespace Acme\CologBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Acme\CologBundle\Entity\treatments;
use Acme\CologBundle\Form\Type\TreatmentsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class TreatmentsController extends Controller
{

//  List Function *****************************/
    public function listTreatmentsAction()
    {
        $treatments = new treatments();
        $treatments->setName('Mezopen arckezelés')
            ->setPrice('3200')
            ->setTime('30')
        ;

        $repository = $this->getDoctrine()->getRepository('AcmeCologBundle:treatments');
        /** @var $repository \Doctrine\ORM\EntityManager */

        $treatment = $repository->findAll();
        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->render('AcmeCologBundle:Default:treatments.html.twig', array(
                'treatment' => $treatment
            ));
        }else{

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

    }

//  Add Function *****************************/
    public function addTreatmentsAction(Request $request)
    {
        $treatments = new treatments();

        $treatments->setName('Mezopen arckezelés')
            ->setPrice('3200')
            ->setTime('30')
        ;


        $addtreatmentform = $form = $this->createForm(new TreatmentsType(), $treatments, array(
            'action' => $this->generateUrl('_addTreatments'),
            'method' => 'POST',
        ));

        $addtreatmentform->handleRequest($request);

        if ($addtreatmentform->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($treatments);
            $em->flush();
            return $this->redirect($this->generateUrl('_addTreatmentsSuccess'));
        }

        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->render('AcmeCologBundle:Default:addtreatments.html.twig', array(
                'addtreatmentform' => $addtreatmentform->createView(),
            ));
        }else{

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }


    }

//  Add Success Function *****************************/
    public function addTreatmentsSuccessAction()
    {
        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->render('AcmeCologBundle:Default:AddTreatmentsFormSuccess.html.twig');
        }else{

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

    }

//  Delete Function *****************************/

    public function deleteTreatmentsAction()
    {
        $request = Request::createFromGlobals();
        $id = $getId = $request->query->get('id');

        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $treatment = $em->getRepository('AcmeCologBundle:treatments')->find(
                $id
            );

            if ($treatment) {
//            exit(\Doctrine\Common\Util\Debug::dump( $treatment));
                $em->remove($treatment);
                $em->flush();
                return $this->redirect($this->generateUrl('_deleteTreatmentsSuccess'));
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
            return $this->redirect($this->generateUrl('_treatments'));
        }else{

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
    }

//  Delete Success Function *****************************/
    public function deleteTreatmentsSuccessAction()
    {

        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            return $this->render('AcmeCologBundle:Default:deleteTreatmentsSuccess.html.twig');
        }else{

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

    }

//  Update Function *****************************/
    public function updateTreatmentsAction(){
        $request = Request::createFromGlobals();
        $id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $treatments = $em->getRepository('AcmeCologBundle:treatments')->find($id);
        $addtreatmentform = $this->createForm(new TreatmentsType(), $treatments);
        if ($request->getMethod() == 'POST') {
            $addtreatmentform->bind($request);
            $id = $request->query->get('id');
            $name = $addtreatmentform["name"]->getData();
            $time = $addtreatmentform["time"]->getData();
            $price = $addtreatmentform['price']->getData();
            $em = $this->getDoctrine()->getManager();
            $treatments = $em->getRepository('AcmeCologBundle:treatments')->find($id);
            $treatments->setName($name);
            $treatments->setTime($time);
            $treatments->setPrice($price);
//            exit(\Doctrine\Common\Util\Debug::dump($id));
            $em->flush();
            return $this->redirect($this->generateUrl('_treatments'));
        }
        return $this->render('AcmeCologBundle:Default:updatetreatments.html.twig', array(
            'addtreatmentform' => $addtreatmentform->createView(),
            'id' => $id,
            'treatments' => $treatments
        ));
    }

}
