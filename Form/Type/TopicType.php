<?php

namespace Tec\Ayt\PortalBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Tec\Ayt\CoreBundle\Entity\Topic;

class TopicType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tec\Ayt\CoreBundle\Entity\Topic',
            'mode' => ''
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

            $builder
                ->add('title', 'text', array(
                    'label' => 'Titulo'
                ))
                ->add('content', 'textarea', array(
                    'label' => 'Contenido'
                ))
                ->add('Crear foro', 'submit');
    }

    public function getName()
    {
        return 'topic';
    }
}