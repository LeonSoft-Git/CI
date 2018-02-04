<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CoreBundle\Entity\Usuarios;
use CoreBundle\Form\UsuariosType;

/**
 * Usuarios controller.
 *
 * @Route("/usuarios")
 */
class UsuariosController extends Controller
{
    /** index test
     * Lists all Usuarios entities.
     *
     * @Route("/", name="usuarios_index")
     * @Method("GET")
     */
    public function indexAction()
    {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            if($user->getTipo() == 1 || $user->getTipo()==2){
                $em = $this->getDoctrine()->getManager();
                $usuarios = $em->getRepository('CoreBundle:Usuarios')->findAll();
                return $this->render('usuarios/index.html.twig', array(
                    'usuarios' => $usuarios,
                ));
            }else{
                return $this->redirect($this->generateUrl('admin_home'));
            }
    }

    /**
     * Creates a new Usuarios entity.
     *
     * @Route("/new", name="usuarios_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1 || $user->getTipo()==2){
            $usuario = new Usuarios();
            $form = $this->createForm('CoreBundle\Form\UsuariosType', $usuario);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $usuario->setVerificado(0);
                $em->persist($usuario);
                $em->flush();

                return $this->redirectToRoute('usuarios_show', array('id' => $usuario->getId()));
            }

            return $this->render('usuarios/new.html.twig', array(
                'usuario' => $usuario,
                'form' => $form->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('admin_home'));
            }
    }

    /**
     * Finds and displays a Usuarios entity.
     *
     * @Route("/{id}", name="usuarios_show")
     * @Method("GET")
     */
    public function showAction(Usuarios $usuario)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1 || $user->getTipo()==2){
            $deleteForm = $this->createDeleteForm($usuario);

            return $this->render('usuarios/show.html.twig', array(
                'usuario' => $usuario,
                'delete_form' => $deleteForm->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('admin_home'));
        }
    }

    /**
     * Displays a form to edit an existing Usuarios entity.
     *
     * @Route("/{id}/edit", name="usuarios_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Usuarios $usuario)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1 || $user->getTipo()==2){
            $deleteForm = $this->createDeleteForm($usuario);
            $editForm = $this->createForm('CoreBundle\Form\UsuariosType', $usuario);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($usuario);
                $em->flush();

                //return $this->redirectToRoute('usuarios_edit', array('id' => $usuario->getId()));
                return $this->redirectToRoute('usuarios_index');

            }

            return $this->render('usuarios/edit.html.twig', array(
                'usuario' => $usuario,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('admin_home'));
        }
    }

    /**
     * Deletes a Usuarios entity.
     *
     * @Route("/{id}", name="usuarios_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Usuarios $usuario)
    {
        $form = $this->createDeleteForm($usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usuario);
            $em->flush();
        }

        return $this->redirectToRoute('usuarios_index');
    }

    /**
     * Creates a form to delete a Usuarios entity.
     *
     * @param Usuarios $usuario The Usuarios entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usuarios $usuario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuarios_delete', array('id' => $usuario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
