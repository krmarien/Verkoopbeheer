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

namespace CommonBundle\Component\Form\Bootstrap;

use Zend\InputFilter\InputFilterAwareInterface;

/**
 * Extending Zend's form component, so that our forms look the way we want
 * them to.
 *
 * @author Kristof Mariën <kristof.marien@litus.cc>
 */
abstract class Form extends \Zend\Form\Form implements InputFilterAwareInterface
{
    /**
     * @var \Zend\InputFilter\InputFilter
     */
    protected $_inputFilter;

	/**
     * @param null|string|int $name Optional name for the element
	 */
    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
    }

    /**
     * Set data to validate and/or populate elements
     *
     * Typically, also passes data on to the composed input filter.
     *
     * @param  array|\ArrayAccess|\Traversable $data
     * @return Form|FormInterface
     * @throws Exception\InvalidArgumentException
     */
    public function setData($data)
    {
        parent::setData($data);

        $this->setInputFilter($this->getInputFilter());
    }
}
