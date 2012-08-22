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
     * @param \CommonBundle\Entity\Stock\Item $item
     * @param null|string|int $name Optional name for the element
     */
    public function __construct(Item $item, $name = null)
    {
        parent::__construct($name);

        $this->remove('submit');

        $field = new Submit('submit');
        $field->setValue('Opslaan');
        $this->add($field);

        $this->populateFromItem($item);
    }
}
