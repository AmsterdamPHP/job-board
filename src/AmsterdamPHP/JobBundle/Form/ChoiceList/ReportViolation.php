<?php

namespace AmsterdamPHP\JobBundle\Form\ChoiceList;

use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

class ReportViolation extends SimpleChoiceList
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
            'spam'  => 'Spam',
            'no_php'  => 'PHP is not a required skill',
            'unrelated' => 'Not related to PHP',
            'duplicate' => 'Duplicated',
            'not_enough_date' => 'Not enough information',
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
