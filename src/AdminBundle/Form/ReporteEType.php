<?php

namespace AdminBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReporteEType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('empresa',EntityType::class,array('class'=>'CoreBundle\Entity\Empresas','label'=>'Empresa',
                'query_builder' => function(EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('e');
                    return $qb;
                }))
            ->add('descargar', SubmitType::class,  array(
                    'label' => 'Descargar')
            )
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'reporteE';
    }
}
