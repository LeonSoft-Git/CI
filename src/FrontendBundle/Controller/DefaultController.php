<?php

namespace FrontendBundle\Controller;

use CoreBundle\Entity\Archivos;
use CoreBundle\Entity\Contactos;
use CoreBundle\Entity\Practicas;
use FrontendBundle\Form\AccesoType;
use FrontendBundle\Form\ContactoType;
use FrontendBundle\Form\RespuestaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('FrontendBundle:Default:index.html.twig');
    }

    /**
     * @Route("/acerca", name="about")
     */
    public function aboutAction(){
        return $this->render('@Frontend/Default/about.html.twig');
    }

    /**
     * @Route("/capacitaciones", name="capacitation")
     */
    public function capacitationAction(){
        return $this->render('@Frontend/Default/capacitation.html.twig');
    }

    /**
     * @Route("/desarrollo-web", name="developer")
     */
    public function developerAction(){
        return $this->render('@Frontend/Default/developer.html.twig');
    }

    /**
     * @Route("/certificaciones", name="certification")
     */
    public function certificationAction(){
        return $this->render('@Frontend/Default/certification.html.twig');
    }

    /**
     * @Route("/ventas", name="sell")
     */
    public function sellAction(){
        return $this->render('@Frontend/Default/sell.html.twig');
    }

    /**
     * @Route("/tutorial-testing", name="tutorial-testing")
     */
    public function tutorialtestingAction(){
        return $this->render('@Frontend/Default/tutorial_testing.html.twig');
    }

    /**
     * @Route("/mantenimiento", name="maintenance")
     */
    public function maintenanceAction(){
        return $this->render('@Frontend/Default/maintenance.html.twig');
    }

    /**
     * @Route("/contacto", name="contact")
     */
    public function contactAction(Request $request){
        $form = $this->createForm(ContactoType::class,null,array(
            'method' => 'POST',
            'attr'=>array('id'=>'contacto-form')
        ));
        $enviado=0;
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($form->isValid()){
                $data = $form->getData();

                $message = \Swift_Message::newInstance()
                    ->setSubject('CI WebPage - Contacto')
                    ->setFrom($data['email'])
                    //->setTo(array('contacto@capacitacioninformatica.com'))
                    ->setTo(array('cesar.rios@capacitacioninformatica.com'))
                    ->setBody(
                        $this->renderView('@Frontend/mail/contact.html.twig',array('contacto'=>$data,)),
                        'text/html'
                    )
                ;
                $contacto = new Contactos();
                $contacto->setNombre($data['nombre']);
                $contacto->setApellidos($data['apellidos']);
                $contacto->setEmail($data['email']);
                $contacto->setTelefono($data['telefono']);
                $contacto->setMensaje($data['mensaje']);
                $contacto->setTipo(1);
                $em->persist($contacto);
                $em->flush();
                $this->get('mailer')->send($message);

                $enviado=1;
            }else{
                $enviado=0;
            }
        }else{
            $enviado=0;
        }

        return $this->render('@Frontend/Default/contact.html.twig', array(
            'form' => $form->createView(),
            'enviado' => $enviado,
        ));
    }

    /**
     * @Route("/error404", name="error404")
     */
    public function error404Action(){
        return $this->render('@Twig/Exception/error404.html.twig');
    }

    /**
     * @Route("/{slug}.{_format}", defaults={"_format": "html"}, requirements={"_format": "html"}, name="acceso")
     */
    public function accesoAction($slug, Request $request){
        $form = $this->createForm(AccesoType::class,null,array(
            'method' => 'POST',
            'attr'=>array('id'=>'acceso-form')
        ));
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $empresas = $em->getRepository('CoreBundle:Empresas')->findOneBy(array('slug'=>$slug));
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if(count($empresas) > 0){
                $archivos = $em->getRepository('CoreBundle:Archivos')->findBy(array('empresas'=>$empresas,'activo'=>1,'tipo'=>1));
                if(count($archivos) > 0){
                    if($archivos[0]->getPassword()==$data['password']){
                        $this->get('session')->start();
                        $this->get('session')->set('empresa',1);
                        $this->get('session')->migrate($destroy = true, $lifetime = 900);
                        return $this->redirect($this->generateUrl('empresas',array('slug'=>$slug)));
                    }else{
                        return $this->render('@Frontend/Default/access.html.twig', array(
                            'form' => $form->createView(),
                            'empresa'=>$empresas, 'slug'=>$slug, 'error'=>'1'
                        ));
                    }
                }else{
                    return $this->render('@Frontend/Default/index.html.twig');
                }
            }else{
                return $this->render('@Frontend/Default/index.html.twig');
            }
        }elseif(count($empresas)>0) {
            return $this->render('@Frontend/Default/access.html.twig', array(
                'form' => $form->createView(),
                'empresa' => $empresas, 'slug' => $slug
            ));
        }else{
            return $this->redirect($this->generateUrl('homepage'));
        }
    }

    /**
     * @Route("/{slug}/practicas", name="empresas")
     */
    public function empresaAction($slug, Request $request){
        if($this->get('session')->get('empresa')==1){
            $em = $this->getDoctrine()->getManager();
            $form = $this->createForm(RespuestaType::class,null,array(
                'method' => 'POST',
                'attr'=>array('id'=>'respuesta-form')
            ));
            $form->handleRequest($request);

            $e = $em->getRepository('CoreBundle:Empresas')->findOneBy(array('slug'=>$slug));
            if(count($e)>0){
                $g = $em->getRepository('CoreBundle:Grupos')->findBy(array('empresas'=>$e,'activo'=>1));
                if(count($g)>0){
                    $c = $em->getRepository('CoreBundle:Cursos')->findAll();
                    $keys = array();
                    foreach ($g as $x):
                        foreach ($c as $y):
                            if($x === $y->getGrupos() && $y->getActivo()==1){
                                array_push($keys, $y->getId());
                            }
                        endforeach;
                    endforeach;
                }else{
                    return $this->redirect($this->generateUrl('homepage'));
                }
            }

            if ($form->isSubmitted()) {
                if($form->isValid()){
                    $data = $form->getData();
                    $practica = new Practicas();
                    $curso = $em->getRepository('CoreBundle:Cursos')->findOneBy(array('id'=>$data['curso']->getId()));
                    $practica->setNombre($data['nombre']);
                    $practica->setApaterno($data['apaterno']);
                    $practica->setAmaterno($data['amaterno']);
                    $practica->setEmail($data['email']);
                    $practica->setCursos($curso);
                    $file = $data['url'];
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($this->getParameter('sol_directory'),$fileName);
                    $practica->setUrl($fileName);
                    $em->persist($practica);
                    $em->flush();
                }
            }

            $empresas = $em->getRepository('CoreBundle:Empresas')->findOneBy(array('slug'=>$slug));
            if(count($empresas) > 0){
                $groups = $em->getRepository('CoreBundle:Grupos')->findBy(array('empresas'=>$em,'activo'=>1));
                $archivos = $em->getRepository('CoreBundle:Archivos')->findBy(array('empresas'=>$empresas,'activo'=>1));
                if(count($archivos) > 0 && count($groups)>0){
                    return $this->render('@Frontend/Default/enterprise.html.twig',array('empresas'=>$empresas,'archivos'=>$archivos,'form'=>$form->createView(),'slug'=>$slug,'keys'=>$keys));
                }else{
                    return $this->redirect($this->generateUrl('homepage'));
                }
            }
        }else{
            return $this->redirect($this->generateUrl('empresas',array('slug'=>$slug)));
        }
    }
}
