<?php

namespace Tec\Ayt\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\HttpFoundation\Request;

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
            ->setMaxResults(8);
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
    public function sendmailAction(Request $request) //Necesita correcciones y el server no esta mandando mails, marco error al tratar.
    {

        $data = $request->request->all();
        exit(\Doctrine\Common\Util\Debug::dump($data));


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
        $error = false;
        try {
            $this->get('mailer')->send($message);
        } catch (\Swift_TransportException $e) {
            $error = true;
            $this->addFlash(
                'notice',
                'Tu mensaje ha sido enviado, pronto nos pondremos en contacto contigo'
            );
        }
        if (!$error) {
            $this->addFlash(
                'notice',
                'Tu mensaje ha sido enviado, pronto nos pondremos en contacto contigo'
            );
        }
        
        return $this->render('TecAytPortalBundle:Main:contact.html.twig',array());
    }
    
}
