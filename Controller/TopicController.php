<?php

namespace Tec\Ayt\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Tec\Ayt\CoreBundle\Entity\Topic;
use Tec\Ayt\CoreBundle\Entity\Reply;

class TopicController extends Controller
{

    const NAMESPACED_CLASS = 'Tec\Ayt\CoreBundle\Entity\Topic';
    const NAMESPACED_FORM_TYPE = 'Tec\Ayt\PortalBundle\Form\Type\TopicType';

    public function listAction()
    {

        $topics = $this->getDoctrine()->getRepository('Tec\Ayt\CoreBundle\Entity\Topic')->findAll();

        return $this->render('TecAytPortalBundle:Topic:list.html.twig', array(
            'topics' => $topics
        ));
    }

    public function processAction(Request $request, $id)
    {
        // Form options
        $options = array();

        /** @var Topic $topic */
        $topic = $this->getDoctrine()->getRepository(self::NAMESPACED_CLASS)->find($id);

        if (!$topic) {
            $class = self::NAMESPACED_CLASS; // PHP bug.
            $topic = new $class();
            $options['mode'] = 'new';
        } else {
            $options['mode'] = 'edit';
        }

        $formType = self::NAMESPACED_FORM_TYPE; // PHP bug.
        $form = $this->createForm(new $formType(), $topic, $options);

        // Check if form was submitted
        $form->handleRequest($request);

        // Check form validation
        if ($form->isValid()) {

            $topic->setUserId($this->getUser());

            // Persist to database using Entity Manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();

            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );

            return $this->redirect(
                $this->generateUrl('tec_ayt_portal_forum_view', array('id' => $topic->getTopicId()))
            );
        }

        // Render as new Entity
        return $this->render('TecAytPortalBundle:Topic:form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function viewAction(Request $request, $id)
    {

        /** @var Topic $topic */
        $topic = $this->getDoctrine()->getRepository('Tec\Ayt\CoreBundle\Entity\Topic')->find($id);

        $reply = new Reply();

        $formType = 'Tec\Ayt\PortalBundle\Form\Type\ReplyType';
        $form = $this->createForm(new $formType(), $reply);

        // Check if form was submitted
        $form->handleRequest($request);

        if ($form->isValid()) {

            $reply->setUserId($this->getUser());
            $reply->setTopicId($topic);
            // Persist to database using Entity Manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($reply);
            $em->flush();
        }

        // retrieve replies
        $replies = $topic->getReplies();

        return $this->render('TecAytPortalBundle:Topic:view.html.twig', array(
            'topic' => $topic,
            'replies' => $replies,
            'form' => $form->createView(),
        ));
    }
}
