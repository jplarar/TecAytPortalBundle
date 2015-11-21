<?php

namespace Tec\Ayt\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContentController extends Controller
{
    public function listAction($id)
    {

        $contents = $this->getDoctrine()->getRepository('Tec\Ayt\CoreBundle\Entity\Content')->findBy(array(
            'albumId' => $id
        ));

        $album = $this->getDoctrine()->getRepository('Tec\Ayt\CoreBundle\Entity\Album')->find($id);

        return $this->render('TecAytPortalBundle:Content:list.html.twig', array(
            'contents' => $contents,
            'album' => $album
        ));
    }
}
