<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuariosType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class,array('label'=>'Nombre'))
            ->add('apaterno',TextType::class,array('label'=>'Apellido Paterno'))
            ->add('amaterno',TextType::class,array('label'=>'Apellido Materno','required'=>false))
            ->add('email',EmailType::class,array('label'=>'Correo Electrónico','required'=>true))
            ->add('password',PasswordType::class,array('required'=>true))
            ->add('tipo',ChoiceType::class,array('choices'=>array('SuperUsuario'=>'1','Administrador'=>'2','Capacitador'=>'3')))
            ->add('activo')
        ;
}

/**
* {@inheritdoc}
*/
public function configureOptions(OptionsResolver $resolver)
{
$resolver->setDefaults(array(
'data_class' => 'CoreBundle\Entity\Usuarios'
));
}

/**
* {@inheritdoc}
*/
public function getBlockPrefix()
{
return 'corebundle_usuarios';
}


}
