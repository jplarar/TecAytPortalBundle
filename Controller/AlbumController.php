<?php

namespace Tec\Ayt\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AlbumController extends Controller
{
    public function listAction()
    {

        $albums = $this->getDoctrine()->getRepository('Tec\Ayt\CoreBundle\Entity\Album')->findAll();

        return $this->render('TecAytPortalBundle:Album:list.html.twig', array(
            'albums' => $albums
        ));
    }
}
