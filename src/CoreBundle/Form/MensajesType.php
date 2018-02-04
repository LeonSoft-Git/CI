<?php

namespace CoreBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MensajesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usuariosRelatedByDestino', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'class' => 'CoreBundle\Entity\Usuarios',
                'label' => 'Usuario',
                'query_builder' => function(EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('s');
                    return $qb
                        ->where('s.activo = 1')
                        ->orderBy('s.nombre', 'ASC');
                },
            ))
            ->add('mensaje',TextareaType::class,array('attr'=>array('rows'=>'5')))
        ;
}

/**
* {@inheritdoc}
*/
public function configureOptions(OptionsResolver $resolver)
{
$resolver->setDefaults(array(
'data_class' => 'CoreBundle\Entity\Mensajes'
));
}

/**
* {@inheritdoc}
*/
public function getBlockPrefix()
{
return 'corebundle_mensajes';
}


}
