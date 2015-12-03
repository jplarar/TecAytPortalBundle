<?php

namespace Tec\Ayt\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LinkController extends Controller
{
   public function listAction()
   {

       $documents = $this->getDoctrine()->getRepository('Tec\Ayt\CoreBundle\Entity\Link')->findAll();


       $freeLink = array();

       /** @var \Tec\Ayt\CoreBundle\Entity\Link $Link */
       foreach ($link as $link) {

               $freeLink[] = $link;

       }

       return $this->render('TecAytPortalBundle:Link:list.html.twig', array(
           'freeLink' => $freeLink
       ));
   }
}
