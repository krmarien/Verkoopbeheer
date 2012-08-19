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

namespace CommonBundle\Form\Activity\Expense;

use CommonBundle\Component\Form\Bootstrap\Element\Select,
    CommonBundle\Component\Form\Bootstrap\Element\Submit,
    CommonBundle\Component\Form\Bootstrap\Element\Text,
    CommonBundle\Component\Validator\Price as PriceValidator,
    CommonBundle\Entity\Activity\Expense,
    Doctrine\ORM\EntityManager;

/**
 * Add a expense.
 */
class Add extends \CommonBundle\Component\Form\Bootstrap\Form
{
    /**
     * @var \Doctrine\ORM\EntityManager The EntityManager instance
     */
    protected $_entityManager = null;

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager The EntityManager instance
     * @param mixed $opts The validator's options
     */
    public function __construct(EntityManager $entityManager, $opts = null)
    {
        parent::__construct($opts);

        $this->_entityManager = $entityManager;

        $field = new Select('type');
        $field->setLabel('Type')
            ->setMultiOptions($this->_getTypes())
            ->setRequired();
        $this->addElement($field);

        $field = new Text('description');
        $field->setLabel('Omschrijving')
            ->setAttrib('class', $field->getAttrib('class') . ' input-xlarge')
            ->setRequired();
        $this->addElement($field);

        $field = new Text('value');
        $field->setLabel('Waarde')
            ->setAttrib('class', $field->getAttrib('class') . ' input-xlarge')
            ->setRequired()
            ->addValidator(new PriceValidator());
        $this->addElement($field);

        $field = new Submit('submit');
        $field->setLabel('Toevoegen');
        $this->addElement($field);

        $this->setActionsGroup(array('submit'));
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

    public function populateFromExpense(Expense $expense)
    {
        $this->populate(
            array(
                'type' => $expense->getTransactionType()->getId(),
                'description' => $expense->getDescription(),
                'value' => number_format($expense->getValue()/100, 2),
            )
        );
    }
}
