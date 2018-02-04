<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\DateTime;

class MiscursosController extends Controller
{
    public function indexAction()
    {
        $mis=null;
        $repository = $this->getDoctrine()->getRepository('CoreBundle:Cursos');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $query = $repository->createQueryBuilder('m')
            ->where('m.usuarios = :user')
            ->orderby('m.fecha','DESC')
            ->setParameter('user', $user)
            ->getQuery();
        $mis = $query->getResult();
        $count = 0;
        $hoy= new \DateTime();
        foreach ($mis as $check):
            if($hoy < $check->getFecha()){
                $count = $count + 1;
            }
        endforeach;
        return $this->render(':partials:cursos.html.twig', array('mis' => $count));
    }
}
