<?php

namespace Tec\Ayt\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ForumController extends Controller
{
    public function listAction()
    {

        $topics = $this->getDoctrine()->getRepository('Tec\Ayt\CoreBundle\Entity\Topic')->findAll();

        return $this->render('TecAytPortalBundle:Topic:list.html.twig', array(
            'topics' => $topics
        ));
    }
}
