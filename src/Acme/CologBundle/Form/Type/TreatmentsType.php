<?php
namespace Acme\CologBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TreatmentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text',array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('price', 'text',array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('time', 'text',array(
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
        return 'treatments';
    }

    public function getPrice()
    {
        return 'treatments';
    }

    public function getTime()
    {
        return 'treatments';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\CologBundle\Entity\Treatments',
        ));
    }
}