<?php

namespace Zizoo\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zizoo\BaseBundle\Entity\Enquiry;
use Zizoo\BaseBundle\Form\EnquiryType;

class PageController extends Controller {

    public function indexAction() 
    {
        $em = $this->getDoctrine()->getEntityManager();

        $boats = $em->getRepository('ZizooBoatBundle:Boat')->getBoats();
        
        return $this->render('ZizooBaseBundle:Page:index.html.twig',array(
            'boats' => $boats
        ));
    }
    
    public function aboutAction()
    {
        return $this->render('ZizooBaseBundle:Page:about.html.twig');
    }
    

}