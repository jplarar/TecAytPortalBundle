<?php

namespace Tec\Ayt\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MainController extends Controller
{
    public function homeAction()
    {

        $banners = $this->getDoctrine()->getRepository('Tec\Ayt\CoreBundle\Entity\Banner')->findAll();
        $sponsors = $this->getDoctrine()->getRepository('Tec\Ayt\CoreBundle\Entity\Sponsor')->findAll();
        /* @var \Doctrine\ORM\EntityRepository $repository */
        $repository = $this->getDoctrine()->getRepository('Tec\Ayt\CoreBundle\Entity\Content');
        $query = $repository->createQueryBuilder('c');
        $query->orderBy('c.timestamp', 'DESC')
            ->getMaxResults(8);
        $contents = $query->getQuery()->getResult();

        return $this->render('TecAytPortalBundle:Main:home.html.twig', array(
            'banners' => $banners,
            'sponsors' => $sponsors,
            'contents' => $contents
        ));
    }

    public function aboutAction()
    {

        return $this->render('TecAytPortalBundle:Main:about.html.twig', array(

        ));
    }

    public function contactAction()
    {

        return $this->render('TecAytPortalBundle:Main:contact.html.twig', array(

        ));
    }
}
