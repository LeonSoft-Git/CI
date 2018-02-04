<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArchivosType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class,array('required'=>true,'attr'=>array('autocomplete'=>'off')))
            ->add('url',FileType::class,array('required'=>false,'data_class'=>null,'attr'=>array('ruta'=>'images'),'label'=>'Archivo'))
            ->add('activo')
            ->add('tipo',ChoiceType::class,array('choices'=>array('Prácticas'=>'1','Manuales'=>'2','Anexos'=>'3')))
            ->add('categoria',ChoiceType::class,array('choices'=>array('Excel'=>'1','PowerPoint'=>'2','Word'=>'3','Anexos'=>'4')))
            ->add('empresas')
        ;
}

/**
* {@inheritdoc}
*/
public function configureOptions(OptionsResolver $resolver)
{
$resolver->setDefaults(array(
'data_class' => 'CoreBundle\Entity\Archivos'
));
}

/**
* {@inheritdoc}
*/
public function getBlockPrefix()
{
return 'corebundle_archivos';
}


}
