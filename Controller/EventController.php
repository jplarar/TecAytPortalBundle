<?php

namespace Tec\Ayt\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventController extends Controller
{
    public function listAction()
    {

        $today = new \DateTime('now');
        $now = $today->format('Y-m-d H:i:s');

        /* @var \Doctrine\ORM\EntityRepository $repository */
        $repository = $this->getDoctrine()->getRepository('Tec\Ayt\CoreBundle\Entity\Event');
        $query = $repository->createQueryBuilder('c');
        $query->orderBy('c.date', 'DESC')
            ->where('c.date > :now' )
            ->setParameter('now', $now);
        $futureEvents = $query->getQuery()->getResult();

        /* @var \Doctrine\ORM\EntityRepository $repository */
        $repository = $this->getDoctrine()->getRepository('Tec\Ayt\CoreBundle\Entity\Event');
        $query = $repository->createQueryBuilder('c');
        $query->orderBy('c.date', 'DESC')
            ->where('c.date < :now' )
            ->setParameter('now', $now)
            ->setMaxResults(10);
        $pastEvents = $query->getQuery()->getResult();

        return $this->render('TecAytPortalBundle:Event:list.html.twig', array(
            'futureEvents' => $futureEvents,
            'pastEvents' => $pastEvents
        ));
    }
}
