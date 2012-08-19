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

namespace CommonBundle\Form\Stock\Sale;

use CommonBundle\Component\Form\Bootstrap\Element\Select,
    CommonBundle\Component\Form\Bootstrap\Element\Submit,
    CommonBundle\Component\Form\Bootstrap\Element\Text,
    Doctrine\ORM\EntityManager,
    Zend\Validator\Int as IntValidator;

/**
 * Add a purchase.
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

        $field = new Select('item');
        $field->setLabel('Item')
            ->setMultiOptions($this->_getItems())
            ->setRequired();
        $this->addElement($field);

        $field = new Text('number');
        $field->setLabel('Aantal')
            ->setAttrib('class', $field->getAttrib('class') . ' input-medium')
            ->setRequired()
            ->addValidator(new IntValidator());
        $this->addElement($field);

        $field = new Submit('submit');
        $field->setLabel('Toevoegen');
        $this->addElement($field);

        $this->setActionsGroup(array('submit'));
    }

    private function _getItems()
    {
        $items = $this->_entityManager
            ->getRepository('CommonBundle\Entity\Stock\Item')
            ->findAll();

        $itemsArray = array();
        foreach ($items as $item) {
            $itemsArray[$item->getId()] = $item->getName();
        }
        return $itemsArray;
    }
}
