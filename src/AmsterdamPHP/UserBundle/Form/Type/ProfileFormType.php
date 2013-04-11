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

        $builder->add('companyName', 'text', array('label' => 'Name of your company'));
        $builder->add('companyUrl', 'url', array('label' => 'Url of your company'));
        $builder->add('companyBio', 'textarea', array('label' => '(Short) description of your company'));
        $builder->add('companyLogo', 'url', array('label' => 'Url of your company logo'));
        $builder->add('recruiter', 'checkbox', array('label' => 'Are you a recruiter?', 'required' => false));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'amsterdamphp_user_profile';
    }
}
