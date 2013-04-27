<?php

namespace AmsterdamPHP\JobBundle\Form\ChoiceList;

use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

/**
 * Class ContractType
 *
 * Holds and represents the types of Contracts available.
 *
 * @package AmsterdamPHP\JobBundle\Form\ChoiceList
 */
class ContractType extends SimpleChoiceList
{
    /**
     * @var array
     */
    protected $options;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->options = array(
            'fulltime'  => 'Full-time',
            'parttime'  => 'Part-time',
            'freelance' => 'Freelance'
        );

        parent::__construct($this->options);
    }

    /**
     * Gets the human-readable text for a stored value
     *
     * @param string $option
     * @return null|string
     */
    public function getLabelForOption($option)
    {
        if ( ! array_key_exists($option, $this->options)) {
            return null;
        }

        return $this->options[$option];
    }
}
