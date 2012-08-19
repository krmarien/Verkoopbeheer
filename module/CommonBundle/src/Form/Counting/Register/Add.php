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
    Zend\Validator\Int as IntValidator;

/**
 * Add a register.
 */
class Add extends \CommonBundle\Component\Form\Bootstrap\Form
{
    /**
     * @param mixed $opts The validator's options
     */
    public function __construct(EntityManager $entityManager, $opts = null)
    {
        parent::__construct($opts);

        $field = new Text('name');
        $field->setLabel('Naam')
            ->setAttrib('class', $field->getAttrib('class') . ' input-xlarge')
            ->setRequired();
        $this->addElement($field);

        $units = $entityManager->getRepository('CommonBundle\Entity\Counting\MoneyUnit')
            ->findAll();
        foreach($units as $unit) {
            $field = new Text('unit_' . $unit->getId());
            $field->setLabel('€ ' . number_format($unit->getValue()/100, 2))
                ->setAttrib('class', $field->getAttrib('class') . ' input-medium')
                ->setValue(0)
                ->setRequired()
                ->addValidator(new IntValidator());
            $this->addElement($field);
        }

        $field = new Submit('submit');
        $field->setLabel('Toevoegen');
        $this->addElement($field);

        $this->setActionsGroup(array('submit'));
    }

    public function populateFromCashRegister(CashRegister $cashRegister)
    {
        $data = array(
            'name' => $cashRegister->getName(),
        );

        foreach($cashRegister->getNumberMoneyUnits() as $number)
            $data['unit_' . $number->getUnit()->getId()] = $number->getNumber();

        $this->populate($data);
    }
}
