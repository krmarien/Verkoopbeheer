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

namespace CommonBundle\Form\Counting\Register;

use CommonBundle\Component\Form\Bootstrap\Element\Submit,
    CommonBundle\Component\Form\Bootstrap\Element\Text,
    CommonBundle\Entity\Counting\CashRegister,
    Doctrine\ORM\EntityManager,
    Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory as InputFactory;

/**
 * Add a register.
 */
class Add extends \CommonBundle\Component\Form\Bootstrap\Form
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $_entityManager;

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param null|string|int $name Optional name for the element
     */
    public function __construct(EntityManager $entityManager, $name = null)
    {
        parent::__construct($name);

        $this->_entityManager = $entityManager;

        $field = new Text('name');
        $field->setLabel('Naam')
            ->setAttribute('class', $field->getAttribute('class') . ' input-xlarge')
            ->setRequired();
        $this->add($field);

        $units = $entityManager->getRepository('CommonBundle\Entity\Counting\MoneyUnit')
            ->findAll();
        foreach($units as $unit) {
            $field = new Text('unit_' . $unit->getId());
            $field->setLabel('€ ' . number_format($unit->getValue()/100, 2))
                ->setAttribute('class', $field->getAttribute('class') . ' input-medium')
                ->setValue(0)
                ->setRequired();
            $this->add($field);
        }

        $field = new Submit('submit');
        $field->setValue('Toevoegen');
        $this->add($field);
    }

    public function populateFromCashRegister(CashRegister $cashRegister)
    {
        $data = array(
            'name' => $cashRegister->getName(),
        );

        foreach($cashRegister->getNumberMoneyUnits() as $number)
            $data['unit_' . $number->getUnit()->getId()] = $number->getNumber();

        $this->setData($data);
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

            $units = $this->_entityManager->getRepository('CommonBundle\Entity\Counting\MoneyUnit')
                ->findAll();
            foreach($units as $unit) {
                $inputFilter->add(
                    $factory->createInput(
                        array(
                            'name'     => 'unit_' . $unit->getId(),
                            'required' => true,
                            'filters'  => array(
                                array('name' => 'StringTrim'),
                            ),
                            'validators' => array(
                                array(
                                    'name'    => 'Int',
                                ),
                            ),
                        )
                    )
                );
            }

            $this->_inputFilter = $inputFilter;
        }
        return $this->_inputFilter;
    }
}
