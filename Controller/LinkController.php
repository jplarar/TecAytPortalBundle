<?php

namespace Tec\Ayt\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LinkController extends Controller
{
   public function listAction()
   {

       $documents = $this->getDoctrine()->getRepository('Tec\Ayt\CoreBundle\Entity\Links')->findAll();


       $freeLinks = array();

       /** @var \Tec\Ayt\CoreBundle\Entity\Links $Links */
       foreach ($links as $links) {

               $freeLinsk[] = $links;

       }

       return $this->render('TecAytPortalBundle:Links:list.html.twig', array(
           'freeLinks' => $freeLinks
       ));
   }
}
