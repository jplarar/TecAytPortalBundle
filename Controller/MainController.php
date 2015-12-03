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

    public function blogAction()
    {

        return $this->render('TecAytPortalBundle:Main:blog.html.twig', array(

        ));
    }
    public function sendmailAction()
    {
        $message = \Swift_Message::newInstance()
        ->setSubject("test")
        ->setFrom('send@example.com')
        ->setTo('linknmasters@gmail.com')
        ->setBody("message",
            'text/plain'
        )
        /*
         * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'Emails/registration.txt.twig',
                array('name' => $name)
            ),
            'text/plain'
        )
        */
    ;
    $this->get('mailer')->send($message);
        
        $this->addFlash(
        'notice',
        'Tu mensaje ha sido enviado, pronto nos pondremos en contacto contigo'
        );
        
        return $this->render("OK");
    }
    
}
