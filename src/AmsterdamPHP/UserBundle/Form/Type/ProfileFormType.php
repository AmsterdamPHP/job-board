<?php

namespace AmsterdamPHP\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

/**
 * Extending base FOS form to add our custom fields
 */
class ProfileFormType extends BaseType
{
    /**
     * {@inheritdoc}
     */
    public function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildUserForm($builder, $options);

        // add your custom field
        $builder->add('name', null, array('label' => 'form.name'));
        $builder->add('linkedin', null, array('label' => 'form.linkedin'));
        $builder->add('facebook', null, array('label' => 'form.facebook'));
        $builder->add('twitter', null, array('label' => 'form.twitter'));
        $builder->add('phone', null, array('label' => 'form.phone'));
        $builder->add('company', null, array('label' => 'form.company'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'amsterdamphp_user_profile';
    }
}
