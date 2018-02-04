<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CoreBundle\Entity\Cursos;
use CoreBundle\Form\CursosType;

/**
 * Cursos controller.
 *
 * @Route("/cursos")
 */
class CursosController extends Controller
{
    /** index test
     * Lists my Cursos entities.
     *
     * @Route("/", name="cursos_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cursos = $em->getRepository('CoreBundle:Cursos')->findBy(array('usuarios'=>$user),array('fecha'=>'DESC'));

        return $this->render('cursos/index.html.twig', array(
            'cursos' => $cursos,
        ));
    }

    /** index test
     * Lists all Cursos entities.
     *
     * @Route("/all", name="cursos_all")
     * @Method("GET")
     */
    public function allAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1 || $user->getTipo()==2){
            $em = $this->getDoctrine()->getManager();
            $cursos = $em->getRepository('CoreBundle:Cursos')->findBy(array(),array('fecha'=>'DESC'));

            return $this->render('cursos/index.html.twig', array(
                'cursos' => $cursos,
            ));
        }else{
            return $this->redirect($this->generateUrl('cursos_index'));
        }
    }

    /**
     * Creates a new Cursos entity.
     *
     * @Route("/new", name="cursos_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1 || $user->getTipo()==2){
            $curso = new Cursos();
            $form = $this->createForm('CoreBundle\Form\CursosType', $curso);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($curso);
                $em->flush();

                return $this->redirectToRoute('cursos_show', array('id' => $curso->getId()));
            }

            return $this->render('cursos/new.html.twig', array(
                'curso' => $curso,
                'form' => $form->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('cursos_index'));
        }
    }

    /**
     * Finds and displays a Cursos entity.
     *
     * @Route("/{id}", name="cursos_show")
     * @Method("GET")
     */
    public function showAction(Cursos $curso)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $deleteForm = $this->createDeleteForm($curso);
        if($curso->getUsuarios()==$user){
            return $this->render('cursos/show.html.twig', array(
                'curso' => $curso,
                'delete_form' => $deleteForm->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('cursos_index'));
        }
    }

    /**
     * Displays a form to edit an existing Cursos entity.
     *
     * @Route("/{id}/edit", name="cursos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Cursos $curso)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1 || $user->getTipo()==2){
            $deleteForm = $this->createDeleteForm($curso);
            $editForm = $this->createForm('CoreBundle\Form\CursosType', $curso);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($curso);
                $em->flush();

                //return $this->redirectToRoute('cursos_edit', array('id' => $curso->getId()));
                return $this->redirectToRoute('cursos_all');

            }

            return $this->render('cursos/edit.html.twig', array(
                'curso' => $curso,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('admin_home'));
        }
    }

    /**
     * Deletes a Cursos entity.
     *
     * @Route("/{id}", name="cursos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Cursos $curso)
    {
        $form = $this->createDeleteForm($curso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($curso);
            $em->flush();
        }

        return $this->redirectToRoute('cursos_index');
    }

    /**
     * Creates a form to delete a Cursos entity.
     *
     * @param Cursos $curso The Cursos entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cursos $curso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cursos_delete', array('id' => $curso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
