<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CoreBundle\Entity\Archivos;

/**
 * Archivos controller.
 *
 * @Route("/archivos")
 */
class ArchivosController extends Controller
{
    /** index test
     * Lists all Archivos entities.
     *
     * @Route("/", name="archivos_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->genPass();
        $em = $this->getDoctrine()->getManager();
        $archivos = $em->getRepository('CoreBundle:Archivos')->findAll();

        if(count($archivos)>0){
            $pass = $archivos[0]->getPassword();
        }else{
            $pass = 'No hay Archivos';
        }

        return $this->render('archivos/index.html.twig', array(
            'archivos' => $archivos,'pass' => $pass
        ));
    }

    /**
     * Creates a new Archivos entity.
     *
     * @Route("/new", name="archivos_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1 || $user->getTipo()==2){
            $archivo = new Archivos();
            $form = $this->createForm('CoreBundle\Form\ArchivosType', $archivo);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                if($archivo->getUrl()){
                    $file = $archivo->getUrl();

                    if($file->guessExtension()=='mpga'){
                        $extension = 'mp3';
                        $fileName = md5(uniqid()).'.'.$extension;
                    }else{
                        $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    }

                    if($archivo->getTipo()==1){
                        $file->move($this->getParameter('prac_directory'),$fileName);
                    }elseif ($archivo->getTipo()==2){
                        $file->move($this->getParameter('man_directory'),$fileName);
                    }elseif ($archivo->getTipo()==3){
                        $file->move($this->getParameter('anex_directory'),$fileName);
                    }

                    $archivo->setUrl($fileName);
                }

                $archivo->setNombre(strtolower($archivo->getNombre()));

                $em->persist($archivo);
                $em->flush();
                $this->genPass();

                return $this->redirectToRoute('archivos_show', array('id' => $archivo->getId()));
            }

            return $this->render('archivos/new.html.twig', array(
                'archivo' => $archivo,
                'form' => $form->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('admin_home'));
        }
    }

    /**
     * Finds and displays a Archivos entity.
     *
     * @Route("/{id}", name="archivos_show")
     * @Method("GET")
     */
    public function showAction(Archivos $archivo)
    {
        $deleteForm = $this->createDeleteForm($archivo);

        return $this->render('archivos/show.html.twig', array(
            'archivo' => $archivo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Archivos entity.
     *
     * @Route("/{id}/edit", name="archivos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Archivos $archivo)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->getTipo() == 1 || $user->getTipo()==2){
            $deleteForm = $this->createDeleteForm($archivo);
            $editForm = $this->createForm('CoreBundle\Form\ArchivosType', $archivo);
            $tmp = $archivo->getUrl();
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();

                if($archivo->getUrl()){
                    $file = $archivo->getUrl();

                    if($file->guessExtension()=='mpga'){
                        $extension = 'mp3';
                        $fileName = md5(uniqid()).'.'.$extension;
                    }else{
                        $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    }

                    if($archivo->getTipo()==1){
                        $file->move($this->getParameter('prac_directory'), $fileName);
                    }elseif($archivo->getTipo()==2){
                        $file->move($this->getParameter('man_directory'), $fileName);
                    }elseif($archivo->getTipo()==3){
                        $file->move($this->getParameter('anex_directory'), $fileName);
                    }

                    $archivo->setUrl($fileName);
                }else{
                    $archivo->setUrl($tmp);
                }
                $archivo->setNombre(strtolower($archivo->getNombre()));
                $em->persist($archivo);
                $em->flush();
                $this->genPass();

                //return $this->redirectToRoute('archivos_edit', array('id' => $archivo->getId()));
                return $this->redirectToRoute('archivos_index');

            }

            return $this->render('archivos/edit.html.twig', array(
                'archivo' => $archivo,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('admin_home'));
        }
    }

    /**
     * Deletes a Archivos entity.
     *
     * @Route("/{id}", name="archivos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Archivos $archivo)
    {
        $form = $this->createDeleteForm($archivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if($archivo->getTipo()==1){
                unlink($this->getParameter('prac_directory').'/'.$archivo->getUrl());
            }elseif($archivo->getTipo()==2){
                unlink($this->getParameter('man_directory').'/'.$archivo->getUrl());
            }elseif($archivo->getTipo()==3){
                unlink($this->getParameter('anex_directory').'/'.$archivo->getUrl());
            }

            $em->remove($archivo);
            $em->flush();
            $this->genPass();
        }

        return $this->redirectToRoute('archivos_index');
    }

    /**
     * Creates a form to delete a Archivos entity.
     *
     * @param Archivos $archivo The Archivos entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Archivos $archivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('archivos_delete', array('id' => $archivo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function genPass(){
        $em = $this->getDoctrine()->getManager();
        $archivos = $em->getRepository('CoreBundle:Archivos')->findAll();
        $pass = substr(md5(uniqid()), 0, 4);
        foreach ($archivos as $f){
            $f->setPassword($pass);
            $em->persist($f);
            $em->flush();
        }
    }
}
