<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\MensajeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CoreBundle\Entity\Mensajes;
use CoreBundle\Form\MensajesType;

/**
 * Mensajes controller.
 *
 * @Route("/mensajes")
 */
class MensajesController extends Controller
{
    /** index test
     * Lists all Mensajes entities.
     *
     * @Route("/", name="mensajes_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('CoreBundle:Mensajes');
        $query = $repository->createQueryBuilder('m')
            ->where('m.usuariosRelatedByDestino = :user')
            ->orwhere('m.usuariosRelatedByOrigen = :user')
            ->andwhere('m.leido = :unr')
            ->orderby('m.created_at','DESC')
            ->setParameter('user', $this->getUser()->getId())
            ->setParameter('unr', '0')
            ->getQuery();
        $unread = $query->getResult();

        $id = array();
        $nombres = array();
        $mensajes = array();
        $un = array();
        foreach ($unread as $check):
            if(!in_array($check->getUsuariosRelatedByDestino()->getId(),$id) && $check->getUsuariosRelatedByDestino()->getId()!=$this->getUser()->getId()){
                array_push($id,$check->getUsuariosRelatedByDestino()->getId());
                array_push($mensajes,$check->getMensaje());
                array_push($nombres,$check->getUsuariosRelatedByDestino()->getNombre()." ".$check->getUsuariosRelatedByDestino()->getApaterno());
            }elseif (!in_array($check->getUsuariosRelatedByOrigen()->getId(),$id) && $check->getUsuariosRelatedByOrigen()->getId()!=$this->getUser()->getId()){
                array_push($id,$check->getUsuariosRelatedByOrigen()->getId());
                array_push($mensajes,$check->getMensaje());
                array_push($nombres,$check->getUsuariosRelatedByOrigen()->getNombre()." ".$check->getUsuariosRelatedByOrigen()->getApaterno());
            }
            if($check->getLeido()==0){
                array_push($un,$check->getUsuariosRelatedByOrigen()->getId());
            }
        endforeach;

        return $this->render('mensajes/index.html.twig', array(
            'id' => $id,'nombres'=>$nombres,'mensajes'=>$mensajes,'unread'=>$un
        ));
    }

    /**
     * Creates a new Mensajes entity.
     *
     * @Route("/new", name="mensajes_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mensaje = new Mensajes();
        $form = $this->createForm('CoreBundle\Form\MensajesType', $mensaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $em = $this->getDoctrine()->getManager();
            $mensaje->setUsuariosRelatedByOrigen($user);
            $mensaje->setLeido(0);
            $message = \Swift_Message::newInstance()
                ->setSubject('CI Administrador - Nuevo Mensaje')
                ->setFrom('noreply@capacitacioninformatica.com')
                //->setTo(array('contacto@capacitacioninformatica.com'))
                ->setTo(array($mensaje->getUsuariosRelatedByDestino()->getEmail()))
                ->setBody(
                    $this->renderView('@Frontend/mail/newmessage.html.twig',array('mensaje'=>$mensaje,)),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);
            $em->persist($mensaje);
            $em->flush();

            return $this->redirectToRoute('mensajes_index');
        }

        return $this->render('mensajes/new.html.twig', array(
            'mensaje' => $mensaje,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Mensajes entity.
     *
     * @Route("/{id}/conversacion", name="mensajes_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Mensajes $mensaje, $id, Request $request)
    {
        $form = $this->createForm(MensajeType::class,null,array(
            'method' => 'POST',
            'attr'=>array('id'=>'chat-form')
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $mensaje = new Mensajes();
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $em = $this->getDoctrine()->getManager();
            $des = $em->getRepository('CoreBundle:Usuarios')->findOneById(array('id'=>$id));
            $mensaje->setUsuariosRelatedByOrigen($user);
            $mensaje->setUsuariosRelatedByDestino($des);
            $mensaje->setMensaje($data['mensaje']);
            $mensaje->setLeido(0);

            $message = \Swift_Message::newInstance()
                ->setSubject('CI Administrador - Nuevo Mensaje')
                ->setFrom('noreply@capacitacioninformatica.com')
                //->setTo(array('contacto@capacitacioninformatica.com'))
                ->setTo(array($mensaje->getUsuariosRelatedByDestino()->getEmail()))
                ->setBody(
                    $this->renderView('@Frontend/mail/newmessage.html.twig',array('mensaje'=>$mensaje,)),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);

            $em->persist($mensaje);
            $em->flush();
            return $this->redirect($this->generateUrl('mensajes_index'));
        }

        $repository = $this->getDoctrine()->getRepository('CoreBundle:Mensajes');
        $query = $repository->createQueryBuilder('m')
            ->where('m.usuariosRelatedByOrigen = :user')
            ->andwhere('m.usuariosRelatedByDestino = :id')
            ->orderby('m.created_at','ASC')
            ->setParameter('user', $this->getUser()->getId())
            ->setParameter('id', $id)
            ->getQuery();
        $enviados = $query->getResult();

        $query = $repository->createQueryBuilder('m')
            ->where('m.usuariosRelatedByOrigen = :id')
            ->andwhere('m.usuariosRelatedByDestino = :user')
            ->orderby('m.created_at','ASC')
            ->setParameter('user', $this->getUser()->getId())
            ->setParameter('id', $id)
            ->getQuery();
        $recibidos = $query->getResult();

        if(count($enviados)>0){
            $destino = array('nombre'=>$enviados[0]->getUsuariosRelatedByDestino()->getNombre(),'apellido'=>$enviados[0]->getUsuariosRelatedByDestino()->getApaterno());
        }elseif (count($recibidos)>0){
            $destino = array('nombre'=>$recibidos[0]->getUsuariosRelatedByDestino()->getNombre(),'apellido'=>$recibidos[0]->getUsuariosRelatedByDestino()->getApaterno());
        }

        if($recibidos[0]->getUsuariosRelatedByDestino()->getId()==$this->getUser()->getId()){
            $em = $this->getDoctrine()->getManager();

            $rec = $em->getRepository('CoreBundle:Mensajes')->findByUsuariosRelatedByDestino(array('id'=>$this->getUser()->getId()));

            foreach ($rec as $l):
                if($l->getUsuariosRelatedByOrigen()->getId()==$id){
                    $l->setLeido(1);
                    $em->persist($l);
                }
            endforeach;
            $em->flush();

            return $this->render('mensajes/show.html.twig', array(
                'form' => $form->createView(),
                'enviados' => $enviados,'destino'=>$destino, 'recibidos'=>$recibidos, 'id'=>$id
            ));
        }else{
            return $this->redirect($this->generateUrl('mensajes_index'));
        }

    }

    /**
     * Displays a form to edit an existing Mensajes entity.
     *
     * @Route("/{id}/edit", name="mensajes_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Mensajes $mensaje)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1){
            $deleteForm = $this->createDeleteForm($mensaje);
            $editForm = $this->createForm('CoreBundle\Form\MensajesType', $mensaje);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($mensaje);
                $em->flush();

                //return $this->redirectToRoute('mensajes_edit', array('id' => $mensaje->getId()));
                return $this->redirectToRoute('mensajes_index');

            }

            return $this->render('mensajes/edit.html.twig', array(
                'mensaje' => $mensaje,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('mensajes_index'));
        }
    }

    /**
     * Deletes a Mensajes entity.
     *
     * @Route("/{id}", name="mensajes_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository('CoreBundle:Mensajes')->findOneBy(array('id'=>$id));
        if (count($message)>0) {
            $em->remove($message);
            $em->flush();
        }

        return $this->redirectToRoute('mensajes_index');
    }

    /**
     * Creates a form to delete a Mensajes entity.
     *
     * @param Mensajes $mensaje The Mensajes entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Mensajes $mensaje)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mensajes_delete', array('id' => $mensaje->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
