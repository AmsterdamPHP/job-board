<?php

namespace AmsterdamPHP\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

/**
 * Extending base FOS form to add our custom fields
 */
class RegistrationFormType extends BaseType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder->add('name', 'text', array('label' => 'form.name'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'amsterdamphp_user_registration';
    }
}
