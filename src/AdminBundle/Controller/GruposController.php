<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CoreBundle\Entity\Grupos;
use CoreBundle\Form\GruposType;

/**
 * Grupos controller.
 *
 * @Route("/grupos")
 */
class GruposController extends Controller
{
    /** index test
     * Lists all Grupos entities.
     *
     * @Route("/", name="grupos_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1 || $user->getTipo()==2){
            $em = $this->getDoctrine()->getManager();

            $grupos = $em->getRepository('CoreBundle:Grupos')->findBy(array(),array('updated_at'=>'DESC'));

            return $this->render('grupos/index.html.twig', array(
                'grupos' => $grupos,
            ));
        }else{
            return $this->redirect($this->generateUrl('admin_home'));
        }
    }

    /**
     * Creates a new Grupos entity.
     *
     * @Route("/new", name="grupos_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1 || $user->getTipo()==2){
            $grupo = new Grupos();
            $form = $this->createForm('CoreBundle\Form\GruposType', $grupo);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($grupo);
                $em->flush();

                return $this->redirectToRoute('grupos_show', array('id' => $grupo->getId()));
            }

            return $this->render('grupos/new.html.twig', array(
                'grupo' => $grupo,
                'form' => $form->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('admin_home'));
        }
    }

    /**
     * Finds and displays a Grupos entity.
     *
     * @Route("/{id}", name="grupos_show")
     * @Method("GET")
     */
    public function showAction(Grupos $grupo)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1 || $user->getTipo()==2){
            $deleteForm = $this->createDeleteForm($grupo);

            return $this->render('grupos/show.html.twig', array(
                'grupo' => $grupo,
                'delete_form' => $deleteForm->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('admin_home'));
        }
    }

    /**
     * Displays a form to edit an existing Grupos entity.
     *
     * @Route("/{id}/edit", name="grupos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Grupos $grupo)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1 || $user->getTipo()==2){
            $deleteForm = $this->createDeleteForm($grupo);
            $editForm = $this->createForm('CoreBundle\Form\GruposType', $grupo);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($grupo);
                $em->flush();

                //return $this->redirectToRoute('grupos_edit', array('id' => $grupo->getId()));
                return $this->redirectToRoute('grupos_index');

            }

            return $this->render('grupos/edit.html.twig', array(
                'grupo' => $grupo,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('admin_home'));
        }
    }

    /**
     * Deletes a Grupos entity.
     *
     * @Route("/{id}", name="grupos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Grupos $grupo)
    {
        $form = $this->createDeleteForm($grupo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($grupo);
            $em->flush();
        }

        return $this->redirectToRoute('grupos_index');
    }

    /**
     * Creates a form to delete a Grupos entity.
     *
     * @param Grupos $grupo The Grupos entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Grupos $grupo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('grupos_delete', array('id' => $grupo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
