<?php
namespace Acme\CologBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text',array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('email', 'email',array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('enabled', 'text',array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('cosmetician', 'text',array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('password', 'password',array(
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
        return 'user';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\UserBundle\Entity\User',
        ));
    }
}