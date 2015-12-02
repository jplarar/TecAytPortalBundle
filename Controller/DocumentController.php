<?php

namespace Tec\Ayt\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DocumentController extends Controller
{
    public function listAction()
    {

        $documents = $this->getDoctrine()->getRepository('Tec\Ayt\CoreBundle\Entity\Document')->findAll();

        $friendDocuments = array();
        $activeDocuments = array();
        $freeDocuments = array();

        /** @var \Tec\Ayt\CoreBundle\Entity\Document $document */
        foreach ($documents as $document) {
            $role = $document->getRole();
            if ($role == 1) {
                $friendDocuments[] = $document;
            } elseif ($role == 2) {
                $activeDocuments[] = $document;
            } else {
                $freeDocuments[] = $document;
            }
        }

        if ($this->get('security.authorization_checker')->isGranted('ROLE_FRIEND')) {
            return $this->render('TecAytPortalBundle:Document:list.html.twig', array(
                'friendDocuments' => $friendDocuments,
                'freeDocuments' => $freeDocuments
            ));
        }

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ACTIVE')) {
            return $this->render('TecAytPortalBundle:Document:list.html.twig', array(
                'activeDocuments' => $activeDocuments,
                'freeDocuments' => $freeDocuments
            ));
        }

        return $this->render('TecAytPortalBundle:Document:list.html.twig', array(
            'freeDocuments' => $freeDocuments
        ));
    }
}
