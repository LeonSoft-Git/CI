<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LeidosController extends Controller
{
    public function indexAction()
    {
        $unread=null;
        $repository = $this->getDoctrine()->getRepository('CoreBundle:Mensajes');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $query = $repository->createQueryBuilder('m')
            ->where('m.usuariosRelatedByDestino = :user')
            ->andwhere('m.leido = :unr')
            ->orderby('m.created_at','DESC')
            ->setParameter('user', $user->getId())
            ->setParameter('unr', '0')
            ->getQuery();
        $unread = $query->getResult();
        return $this->render(':partials:mensajes.html.twig', array('unread' => $unread));
    }
}
