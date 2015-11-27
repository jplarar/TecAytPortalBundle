<?php

namespace Tec\Ayt\PortalBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Tec\Ayt\CoreBundle\Entity\User;

class UserType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tec\Ayt\CoreBundle\Entity\User',
            'mode' => '',
            'password' => false,
            'role' => ''
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['password']) {
            $builder
                ->add('password', 'repeated', array(
                    'first_name' => 'password',
                    'second_name' => 'confirm',
                    'type' => 'password',
                    'mapped' => false
                ))
                ->add('submit', 'submit');
        } else {
            $builder
                ->add('username', 'text', array(
                    'label' => 'Nombre de usuario (username)'
                ))
                ->add('fullName', 'text', array(
                    'label' => 'Nombre completo'
                ))
                ->add('email', 'email');
            if($options['mode'] == 'new') {
                $builder
                    ->add('password', 'repeated', array(
                        'first_name' => 'password',
                        'second_name' => 'confirm',
                        'type' => 'password',
                        'first_options'  => array('label' => 'Contraseña'),
                        'second_options' => array('label' => 'Confirma tu contraseña'),
                    ));
            }
                if ($options['role'] == 'ROLE_ACTIVE') {
                    $builder
                        ->add('birthDate', 'text', array(
                            'label' => 'Fecha de nacimiento'
                        ))
                        ->add('gender', 'choice', array(
                            'label' => 'Sexo',
                            'choices'   => array('1' => 'Masculino',
                                '0' => 'Femenino')
                        ))
                        ->add('state', 'text', array(
                            'label' => 'Estado',
                            'attr' => array(
                                'placeholder' => 'Nuevo León',
                            ),
                        ))
                        ->add('city', 'text', array(
                            'label' => 'Ciudad',
                            'attr' => array(
                                'placeholder' => 'Monterrey',
                            ),
                        ))
                        ->add('work', 'text', array(
                            'label' => 'Experiencia profesional',
                            'attr' => array(
                                'placeholder' => 'Director de ventas en X',
                            ),
                        ))
                        ->add('education', 'choice', array(
                            'choices'   => User::getAvailableEducations(),
                            'label' => 'Nivel de estudios'
                        ));
                }
            $builder
                ->add('Crear usuario', 'submit');
        }
    }

    public function getName()
    {
        return 'user';
    }
}