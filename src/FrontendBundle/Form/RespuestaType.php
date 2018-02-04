<?php

namespace FrontendBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RespuestaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('curso',EntityType::class,array('class'=>'CoreBundle\Entity\Cursos','label'=>'Curso',
                'query_builder' => function(EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('c');
                    return $qb
                        ->where('c.activo=1')
                        ;
                }))
            ->add('nombre', TextType::class,array(
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
            ->add('apaterno', TextType::class,array(
                'label' => 'Apellido Paterno',
                'required'=>true,
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Ingresa tu apellido paterno',
                    )),
                    new Length(array('min' => 3,
                        'minMessage' => 'El apellido paterno debe ser mayor a {{ limit }} letras',
                    )),
                ),
                'attr' => array('placeholder' => 'Apellido Paterno*','autocomplete'=>'off')
            ))
            ->add('amaterno', TextType::class,array(
                'label' => 'Apellido Materno',
                'required'=>true,
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Ingresa tu apellido materno',
                    )),
                    new Length(array('min' => 3,
                        'minMessage' => 'El apellido materno debe ser mayor a {{ limit }} letras',
                    )),
                ),
                'attr' => array('placeholder' => 'Apellido Materno*','autocomplete'=>'off')
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
            ->add('url', FileType::class, [
                'required' => true,
                'label'=>'Archivo',
                'constraints' => [
                    new File([
                        'maxSize' => '25M',
                        'maxSizeMessage'=>'Archivo demasiado grande',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'application/msword',
                            'application/vnd.ms-powerpoint',
                            'application/x-rar-compressed',
                            'application/zip',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                        ],
                        'mimeTypesMessage' => 'Revisa tu archivo. Formato no permitido.',
                    ])
                ]
            ])
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
        return 'answer';
    }
}
