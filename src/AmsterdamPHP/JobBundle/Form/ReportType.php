<?php

namespace AmsterdamPHP\JobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reason', 'textarea', array(
                'label' => 'Reason',
                'constraints' => new Length(array(
                    'min' => 50,
                ))
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
