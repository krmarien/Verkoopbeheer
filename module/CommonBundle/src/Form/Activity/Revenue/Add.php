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

namespace CommonBundle\Form\Activity\Revenue;

use Zend\Form\Element\Select,
    CommonBundle\Component\Form\Bootstrap\Element\Submit,
    CommonBundle\Component\Form\Bootstrap\Element\Text,
    CommonBundle\Component\Validator\Price as PriceValidator,
    CommonBundle\Entity\Activity\Revenue,
    Doctrine\ORM\EntityManager,
    Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory as InputFactory;

/**
 * Add a revenue.
 */
class Add extends \CommonBundle\Component\Form\Bootstrap\Form
{
    /**
     * @var \Doctrine\ORM\EntityManager The EntityManager instance
     */
    protected $_entityManager = null;

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager The EntityManager instance
     * @param null|string|int $name Optional name for the element
     */
    public function __construct(EntityManager $entityManager, $name = null)
    {
        parent::__construct($name);

        $this->_entityManager = $entityManager;

        $field = new Select('type');
        $field->setLabel('Type')
            ->setAttribute('options', $this->_getTypes());
        $this->add($field);

        $field = new Text('description');
        $field->setLabel('Omschrijving')
            ->setAttribute('class', $field->getAttribute('class') . ' input-xlarge');
        $this->add($field);

        $field = new Text('value');
        $field->setLabel('Waarde')
            ->setAttribute('class', $field->getAttribute('class') . ' input-xlarge');
        $this->add($field);

        $field = new Submit('submit');
        $field->setValue('Toevoegen');
        $this->add($field);
    }

    private function _getTypes()
    {
        $types = $this->_entityManager
            ->getRepository('CommonBundle\Entity\Activity\TransactionType')
            ->findAll();

        $typesArray = array();
        foreach ($types as $type) {
            $typesArray[$type->getId()] = $type->getName();
        }
        return $typesArray;
    }

    public function populateFromRevenue(Revenue $revenue)
    {
        $this->setData(
            array(
                'type' => $revenue->getTransactionType()->getId(),
                'description' => $revenue->getDescription(),
                'value' => number_format($revenue->getValue()/100, 2),
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
                        'name'     => 'type',
                        'required' => true,
                    )
                )
            );

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'     => 'description',
                        'required' => true,
                        'filters'  => array(
                            array('name' => 'StringTrim'),
                        ),
                    )
                )
            );

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'     => 'value',
                        'required' => true,
                        'filters'  => array(
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            new PriceValidator()
                        ),
                    )
                )
            );
            $this->_inputFilter = $inputFilter;
        }
        return $this->_inputFilter;
    }
}
