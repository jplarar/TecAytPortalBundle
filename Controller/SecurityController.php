<?php

namespace Tec\Ayt\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;


class SecurityController extends Controller
{
    public function errorAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        // $lastUsername = $authenticationUtils->getLastUsername();
        //exit(\Doctrine\Common\Util\Debug::dump($error));

        return $this->render('TecAytPortalBundle:Security:error.html.twig', array('error' => $error));
    }

    public function successAction()
    {
        return $this->render('TecAytPortalBundle:Security:success.html.twig');
    }
}
