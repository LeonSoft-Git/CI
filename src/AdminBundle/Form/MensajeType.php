<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class MensajeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('mensaje', TextareaType::class,array(
                'label' => 'Mensaje',
                'required'=>true,
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Ingresa un mensaje',
                    )),
                ),
                'attr' => array('placeholder' => 'Mensaje','rows'=>'5','autocomplete'=>'off')
            ))
            ->add('enviar', SubmitType::class,  array(
                    'label' => 'Enviar')
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'admin_bundle_mensaje_type';
    }
}
