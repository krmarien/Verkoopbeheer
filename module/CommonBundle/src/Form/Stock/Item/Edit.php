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

namespace CommonBundle\Form\Stock\Item;

use CommonBundle\Component\Form\Bootstrap\Element\Submit,
    CommonBundle\Entity\Stock\Item;

/**
 * Edit a stock item.
 */
class Edit extends Add
{
    /**
     * @param mixed $opts The validator's options
     */
    public function __construct(Item $item, $opts = null)
    {
        parent::__construct($opts);

        $this->removeElement('submit');

        $field = new Submit('submit');
        $field->setLabel('Opslaan');
        $this->addElement($field);

        $this->setActionsGroup(array('submit'));

        $this->populateFromItem($item);
    }
}
