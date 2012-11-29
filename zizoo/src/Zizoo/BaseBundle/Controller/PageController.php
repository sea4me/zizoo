<?php

namespace Zizoo\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zizoo\BaseBundle\Entity\Enquiry;
use Zizoo\BaseBundle\Form\EnquiryType;

class PageController extends Controller {

    public function indexAction() {
        return $this->render('ZizooBaseBundle:Page:index.html.twig');
    }

}