<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CoreBundle\Entity\Practicas;
use CoreBundle\Form\PracticasType;

/**
 * Practicas controller.
 *
 * @Route("/practicas")
 */
class PracticasController extends Controller
{
    /** index test
     * Lists all Practicas entities.
     *
     * @Route("/", name="practicas_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $practicas = $em->getRepository('CoreBundle:Practicas')->findAll();

        return $this->render('practicas/index.html.twig', array(
            'practicas' => $practicas,
        ));
    }

    /**
     * Creates a new Practicas entity.
     *
     * @Route("/new", name="practicas_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1){
            $practica = new Practicas();
            $form = $this->createForm('CoreBundle\Form\PracticasType', $practica);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                if($practica->getUrl()){
                    $file = $practica->getUrl();

                    $fileName = md5(uniqid()).'.'.$file->guessExtension();

                    $file->move(
                        $this->getParameter('sol_directory'),
                        $fileName
                    );

                    $practica->setUrl($fileName);
                }

                $em->persist($practica);
                $em->flush();

                return $this->redirectToRoute('practicas_show', array('id' => $practica->getId()));
            }

            return $this->render('practicas/new.html.twig', array(
                'practica' => $practica,
                'form' => $form->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('admin_home'));
        }
    }

    /**
     * Finds and displays a Practicas entity.
     *
     * @Route("/{id}", name="practicas_show")
     * @Method("GET")
     */
    public function showAction(Practicas $practica)
    {
        $deleteForm = $this->createDeleteForm($practica);

        return $this->render('practicas/show.html.twig', array(
            'practica' => $practica,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Practicas entity.
     *
     * @Route("/{id}/edit", name="practicas_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Practicas $practica)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1){
            $deleteForm = $this->createDeleteForm($practica);
            $editForm = $this->createForm('CoreBundle\Form\PracticasType', $practica);
            $tmp = $practica->getUrl();
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();

                if($practica->getUrl()){
                    $file = $practica->getUrl();

                    $fileName = md5(uniqid()).'.'.$file->guessExtension();

                    $file->move(
                        $this->getParameter('sol_directory'),
                        $fileName
                    );

                    $practica->setUrl($fileName);
                }else{
                    $practica->setUrl($tmp);
                }

                $em->persist($practica);
                $em->flush();

                //return $this->redirectToRoute('practicas_edit', array('id' => $practica->getId()));
                return $this->redirectToRoute('practicas_index');

            }

            return $this->render('practicas/edit.html.twig', array(
                'practica' => $practica,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('admin_home'));
        }
    }

    /**
     * Deletes a Practicas entity.
     *
     * @Route("/{id}", name="practicas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Practicas $practica)
    {
        $form = $this->createDeleteForm($practica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            unlink($this->getParameter('sol_directory').'/'.$practica->getUrl());
            $em->remove($practica);
            $em->flush();
        }

        return $this->redirectToRoute('practicas_index');
    }

    /**
     * Creates a form to delete a Practicas entity.
     *
     * @param Practicas $practica The Practicas entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Practicas $practica)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('practicas_delete', array('id' => $practica->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
