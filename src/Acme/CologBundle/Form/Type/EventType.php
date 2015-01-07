<?php
namespace Acme\CologBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text',array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('startDatetime', 'text',array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('Ment', 'submit',array(
                'attr' => array(
                    'class' => 'btn btn-success'
                )
            ))
        ;
    }

    public function getName()
    {
        return 'event';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\CologBundle\Entity\EventEntity',
        ));
    }
}