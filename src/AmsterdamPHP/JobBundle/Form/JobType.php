<?php

namespace AmsterdamPHP\JobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('location')
            ->add('expires', 'date', array( 'data' => new \DateTime("+1 month")))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AmsterdamPHP\JobBundle\Entity\Job'
        ));
    }

    public function getName()
    {
        return 'amsterdamphp_jobbundle_jobtype';
    }
}
