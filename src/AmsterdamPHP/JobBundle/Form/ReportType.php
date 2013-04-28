<?php

namespace AmsterdamPHP\JobBundle\Form;

use AmsterdamPHP\JobBundle\Form\ChoiceList\ReportViolation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reason', 'choice', array(
                'label' => 'Reason',
                'choice_list' => new ReportViolation()
            ))
            ->add('description', 'textarea', array(
                'label' => 'Notes',
            ))
            ->add('name', 'text', array(
                'label' => 'Name (optional)',
                'required' => false,
            ))
            ->add('email', 'email', array(
                'label' => 'Email (optional)',
                'required' => false,
            ))
        ;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'amsterdamphp_jobbundle_reporttype';
    }
}
