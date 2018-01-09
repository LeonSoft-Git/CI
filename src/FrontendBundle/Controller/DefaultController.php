<?php

namespace FrontendBundle\Controller;

use FrontendBundle\Form\ContactoType;
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
     * @Route("/lasalle", name="salle")
     */
    public function salleAction(){
        return $this->render('@Frontend/Default/practice.html.twig');
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
}
