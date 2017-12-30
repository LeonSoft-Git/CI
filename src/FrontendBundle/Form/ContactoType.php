<?php

namespace FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', TextType::class,array(
                'label' => 'Nombre',
                'required'=>true,
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Ingresa tu nombre',
                    )),
                    new Length(array('min' => 3,
                        'minMessage' => 'El nombre debe ser mayor a {{ limit }} letras',
                    )),
                ),
                'attr' => array('placeholder' => 'Nombre(s)*','autocomplete'=>'off')
            ))
            ->add('apellidos', TextType::class,array(
                'label' => 'Apellidos',
                'required'=>true,
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Ingresa tu apellido',
                    )),
                    new Length(array('min' => 3,
                        'minMessage' => 'El apellido debe ser mayor a {{ limit }} letras',
                    )),
                ),
                'attr' => array('placeholder' => 'Apellido(s)*','autocomplete'=>'off')
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Correo Electrónico',
                'required'=>true,
                'constraints' => array(
                    new Email(array(
                        'message' => 'El correo electrónico \'{{ value }}\' no es válido',
                    )),
                    new NotBlank(array(
                        'message' => 'Ingresa un correo electrónico',
                    )),
                    new Length(array('min' => 3,
                        'minMessage' => 'El correo electrónico debe ser mayor a {{ limit }} dígitos',)),
                ),
                'attr' => array('placeholder' => 'correo@dominio.com','autocomplete'=>'off'),
                'trim' => true
            ))
            ->add('telefono', TextType::class,array(
                'label' => 'Teléfono (con lada)',
                'required'=>true,
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Ingresa un Teléfono',
                    )),
                    new Length(array('min' => 7,
                        'minMessage' => 'El teléfono debe ser mayor a {{ limit }} letras',
                    )),
                ),
                'attr' => array('placeholder' => '(722)1234567','autocomplete'=>'off')
            ))
            ->add('mensaje', TextareaType::class,array(
                'label' => 'Mensaje',
                'required'=>true,
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Ingresa un mensaje o una pregungta',
                    )),
                ),
                'attr' => array('placeholder' => 'Mensaje o Pregunta*','rows'=>'5','autocomplete'=>'off')
            ))
            ->add('enviar', SubmitType::class,  array(
                    'label' => 'Enviar')
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'contact';
    }
}
