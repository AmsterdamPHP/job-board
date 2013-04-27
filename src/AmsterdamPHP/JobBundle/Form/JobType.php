<?php

namespace AmsterdamPHP\JobBundle\Form;

use AmsterdamPHP\JobBundle\Form\ChoiceList\ContractType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('languageOfAd', 'choice', array(
                'label' => 'Language',
                'choices' => array('en' => 'English', 'nl' => 'Dutch')
            ))
            ->add('description')
            ->add('contractType', 'choice', array(
                'label' => 'Type of contract',
                'choice_list' => new ContractType()
            ))
            ->add('location')
            ->add('salary', 'text', array(
                'required' => false
            ))
            ->add('url', 'url', array(
                'required' => false
            ))
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
