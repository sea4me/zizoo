<?php

namespace Zizoo\BoatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Boat controller.
 */
class BoatController extends Controller 
{
    /**
     * Show a boat entry
     */
    public function showAction($id) 
    {
        $em = $this->getDoctrine()->getEntityManager();

        $boat = $em->getRepository('ZizooBoatBundle:Boat')->find($id);

        if (!$boat) {
            throw $this->createNotFoundException('Unable to find boat post.');
        }

        $images = $em->getRepository('ZizooBoatBundle:Image')
                     ->getImagesForBoat($boat->getId());

        return $this->render('ZizooBoatBundle:Boat:show.html.twig', array(
            'boat' => $boat,
            'images'  => $images
        ));
    }

}