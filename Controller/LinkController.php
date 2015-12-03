<?php

namespace Tec\Ayt\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LinkController extends Controller
{
   public function listAction()
   {

       $links = $this->getDoctrine()->getRepository('Tec\Ayt\CoreBundle\Entity\Link')->findAll();


       $freeLinks = array();

       /** @var \Tec\Ayt\CoreBundle\Entity\Link $Link */
       foreach ($links as $link) {

               $freeLinks[] = $link;

       }

       return $this->render('TecAytPortalBundle:Link:list.html.twig', array(
           'freeLinks' => $freeLinks
       ));
   }
}
