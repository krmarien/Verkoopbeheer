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

namespace CommonBundle\Component\Form\Bootstrap\Element;

use CommonBundle\Component\Form\Bootstrap\Decorator\Errors,
	Zend\Form\Decorator;

/**
 * Textarea form element
 *
 * @author Kristof Mariën <kristof.marien@litus.cc>
 */
class Textarea extends \CommonBundle\Component\Form\Bootstrap\Element
{

    public $helper = 'formTextarea';

    /**
     * Create new Textarea
     *
     * @param  string|array|Config $spec
     * @param  array|Traversable $options
     * @return void
     * @throws ElementException if no element name after initialization
     */
    public function __construct($spec, $options = null)
    {
    	parent::__construct($spec, $options);
    	$this->setAttrib('class', 'input-xxlarge');
    	$this->setAttrib('rows', 10);
    }
}
