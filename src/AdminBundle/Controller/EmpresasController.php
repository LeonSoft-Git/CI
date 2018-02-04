<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CoreBundle\Entity\Empresas;
use CoreBundle\Form\EmpresasType;

/**
 * Empresas controller.
 *
 * @Route("/empresas")
 */
class EmpresasController extends Controller
{
    /** index test
     * Lists all Empresas entities.
     *
     * @Route("/", name="empresas_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1 || $user->getTipo()==2){
            $em = $this->getDoctrine()->getManager();

            $empresas = $em->getRepository('CoreBundle:Empresas')->findAll();

            return $this->render('empresas/index.html.twig', array(
                'empresas' => $empresas,
            ));
        }else{
            return $this->redirect($this->generateUrl('admin_home'));
        }
    }

    /**
     * Creates a new Empresas entity.
     *
     * @Route("/new", name="empresas_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1 || $user->getTipo()==2){
            $empresa = new Empresas();
            $form = $this->createForm('CoreBundle\Form\EmpresasType', $empresa);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($empresa);
                $em->flush();

                return $this->redirectToRoute('empresas_show', array('id' => $empresa->getId()));
            }

            return $this->render('empresas/new.html.twig', array(
                'empresa' => $empresa,
                'form' => $form->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('admin_home'));
        }
    }

    /**
     * Finds and displays a Empresas entity.
     *
     * @Route("/{id}", name="empresas_show")
     * @Method("GET")
     */
    public function showAction(Empresas $empresa)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1 || $user->getTipo()==2){
            $deleteForm = $this->createDeleteForm($empresa);

            return $this->render('empresas/show.html.twig', array(
                'empresa' => $empresa,
                'delete_form' => $deleteForm->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('admin_home'));
        }
    }

    /**
     * Displays a form to edit an existing Empresas entity.
     *
     * @Route("/{id}/edit", name="empresas_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Empresas $empresa)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1 || $user->getTipo()==2){
            $deleteForm = $this->createDeleteForm($empresa);
            $editForm = $this->createForm('CoreBundle\Form\EmpresasType', $empresa);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($empresa);
                $em->flush();

                //return $this->redirectToRoute('empresas_edit', array('id' => $empresa->getId()));
                return $this->redirectToRoute('empresas_index');

            }

            return $this->render('empresas/edit.html.twig', array(
                'empresa' => $empresa,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('admin_home'));
        }
    }

    /**
     * Deletes a Empresas entity.
     *
     * @Route("/{id}", name="empresas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Empresas $empresa)
    {
        $form = $this->createDeleteForm($empresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($empresa);
            $em->flush();
        }

        return $this->redirectToRoute('empresas_index');
    }

    /**
     * Creates a form to delete a Empresas entity.
     *
     * @param Empresas $empresa The Empresas entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Empresas $empresa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('empresas_delete', array('id' => $empresa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
