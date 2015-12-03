<?php

namespace Tec\Ayt\PortalBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Tec\Ayt\CoreBundle\Entity\Reply;

class ReplyType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tec\Ayt\CoreBundle\Entity\Reply',
            'mode' => ''
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

            $builder
                ->add('content', 'textarea', array(
                    'label' => 'Respuesta'
                ))
                ->add('Crear Respuesta', 'submit');
    }

    public function getName()
    {
        return 'reply';
    }
}