<?php
namespace Acme\CologBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text',array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('email', 'email',array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('phone', 'text',array(
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
        return 'guest';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\CologBundle\Entity\guest',
        ));
    }
}