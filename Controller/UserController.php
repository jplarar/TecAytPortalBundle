<?php

namespace Tec\Ayt\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Tec\Ayt\CoreBundle\Entity\User;

class UserController extends Controller
{
    public function listAction()
    {

        return $this->render('TecAytPortalBundle:User:list.html.twig', array(
        ));
    }

    const NAMESPACED_CLASS = 'Tec\Ayt\CoreBundle\Entity\User';
    const NAMESPACED_FORM_TYPE = 'Tec\Ayt\PortalBundle\Form\Type\UserType';

    public function processAction(Request $request, $id, $type)
    {
        // Form options
        $options = array();

        /** @var User $user */
        $user = $this->getDoctrine()->getRepository(self::NAMESPACED_CLASS)
            ->findOneBy(array('userId' => $id));

        if (!$user) {

            // define form for each role
            if ($type == 1){
                $role = 'ROLE_FRIEND';
            } else {
                $role = 'ROLE_ACTIVE';
            }

            $class = self::NAMESPACED_CLASS; // PHP quirk.
            $user = new $class();
            $options['mode'] = 'new';
            $options['role'] = $role;
            $user->setRole($role);
        } else {
            $options['mode'] = 'edit';
            $options['role'] = $user->getRole();
            $user->setBirthDate($user->getBirthDate()->format('Y-m-d'));
        }

        $formType = self::NAMESPACED_FORM_TYPE; // PHP quirk.
        $form = $this->createForm(new $formType(), $user, $options);

        // Check if form was submitted
        $form->handleRequest($request);

        // Check form validation
        if ($form->isValid()) {

            // Clean date
            $birthDate = new \DateTime($user->getBirthDate());
            $user->setBirthDate($birthDate);

            $em = $this->getDoctrine()->getManager();
            ## Extend the default form validation
            if($user->getUserId() <= 0){
                // Load security encoder
                $factory = $this->get('security.encoder_factory');

                /* @var \Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface $encoder */
                $encoder = $factory->getEncoder($user);
                $encodedPassword = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($encodedPassword);

                $em->persist($user);
            }

            // Persist to database using Entity Manager
            $em->flush();

            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );

            return $this->redirect(
                $this->generateUrl('tec_ayt_portal_user_profile')
            );
        }

        // Render as new Entity
        return $this->render('TecAytPortalBundle:User:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function passwordAction(Request $request, $id)
    {
        // Form options
        $options = array();

        /** @var User $user */
        $user = $this->getDoctrine()->getRepository(self::NAMESPACED_CLASS)
            ->findOneBy(array('userId' => $id));

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $options['password'] = true;

        $formType = self::NAMESPACED_FORM_TYPE; // PHP quirk.
        $form = $this->createForm(new $formType(), $user, $options);

        // Check if form was submitted
        $form->handleRequest($request);

        // Check form validation
        if ($form->isValid()) {

            $password = $form->get('password');
            ## Extend the default form validation
            $factory = $this->get('security.encoder_factory');

            /* @var \Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface $encoder */
            $encoder = $factory->getEncoder($user);
            $encodedPassword = $encoder->encodePassword($password, $user->getSalt());
            $user->setPassword($encodedPassword);

            // Persist to database using Entity Manager
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );

            return $this->redirect(
                $this->generateUrl('tec_ayt_admin_user_list')
            );
        }

        // Render as new Entity
        return $this->render('TecAytAdminBundle:User:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function profileAction()
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('TecAytPortalBundle:User:view.html.twig', array(
            'user' => $user
        ));
    }
}
