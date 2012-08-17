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
 
namespace CommonBundle\Component\Form\Common\Decorator;

use Zend\Form\Decorator\ViewHelper;

/**
* This decorator combines all decorators needed to decorate a field with a label.
*
* @author Niels Avonds <niels.avonds@litus.cc>
*/
class ButtonDecorator extends \Zend\Form\Decorator\AbstractDecorator
{
	/**
     * Decorate content and/or element
     *
     * @param string $content The element's content
     * @return string
     */
    public function render($content)
    {
    	$viewHelper = new ViewHelper();
    	$viewHelper->setElement($this->getElement());
    	$content = $viewHelper->render($content);

        $this->getElement()->setLabel('');

    	$divSpanWrapper = new DivDivWrapper();
    	$divSpanWrapper->setElement($this->getElement());
    	$content = $divSpanWrapper->render($content);

    	return $content;
    }
}
