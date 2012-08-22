<?php
/**
 * Litus is a project by a group of students from the K.U.Leuven. The goal is to create
 * various applications to support the IT needs of student unions.
 *
 * @author Karsten Daemen <karsten.daemen@litus.cc>
 * @author Bram Gotink <bram.gotink@litus.cc>
 * @author Pieter Maene <pieter.maene@litus.cc>
 * @author Kristof Mariën <kristof.marien@litus.cc>
 * @author Michiel Staessen <michiel.staessen@litus.cc>
 * @author Alan Szepieniec <alan.szepieniec@litus.cc>
 *
 * @license http://litus.cc/LICENSE
 */

namespace CommonBundle\Form\Counting;

use CommonBundle\Component\Form\Bootstrap\Element\Submit,
    CommonBundle\Component\Form\Bootstrap\Element\Text,
    CommonBundle\Entity\Counting\Counting,
    Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory as InputFactory;

/**
 * Add a counting.
 */
class Add extends \CommonBundle\Component\Form\Bootstrap\Form
{
    /**
     * @param null|string|int $name Optional name for the element
     */
    public function __construct($name = null)
    {
        parent::__construct($name);

        $field = new Text('name');
        $field->setLabel('Naam')
            ->setAttribute('class', $field->getAttribute('class') . ' input-xlarge');
        $this->add($field);

        $field = new Submit('submit');
        $field->setValue('Toevoegen');
        $this->add($field);
    }

    public function populateFromCounting(Counting $counting)
    {
        $this->setData(
            array(
                'name' => $counting->getDescription(),
            )
        );
    }

    public function getInputFilter()
    {
        if ($this->_inputFilter == null) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'     => 'name',
                        'required' => true,
                        'filters'  => array(
                            array('name' => 'StringTrim'),
                        ),
                    )
                )
            );
            $this->_inputFilter = $inputFilter;
        }
        return $this->_inputFilter;
    }
}
