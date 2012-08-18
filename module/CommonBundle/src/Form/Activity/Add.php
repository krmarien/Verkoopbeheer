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
 
namespace CommonBundle\Form\Activity;

use CommonBundle\Component\Form\Bootstrap\Element\Submit,
    CommonBundle\Component\Form\Bootstrap\Element\Text,
    CommonBundle\Entity\Activity\Activity,
    Zend\Validator\Date as DateValidator;

/**
 * Add an activity.
 */
class Add extends \CommonBundle\Component\Form\Bootstrap\Form
{
    /**
     * @param \Doctrine\ORM\EntityManager $entityManager The EntityManager instance
     * @param mixed $opts The validator's options
     */
    public function __construct($opts = null)
    {
        parent::__construct($opts);

        $field = new Text('name');
        $field->setLabel('Naam')
            ->setAttrib('class', $field->getAttrib('class') . ' input-xlarge')
            ->setRequired();
        $this->addElement($field);

        $field = new Text('location');
        $field->setLabel('Locatie')
            ->setAttrib('class', $field->getAttrib('class') . ' input-xxlarge')
            ->setRequired();
        $this->addElement($field);

        $field = new Text('date');
        $field->setLabel('Datum')
            ->setAttrib('class', $field->getAttrib('class') . ' input-large')
            ->setRequired()
            ->addValidator(new DateValidator('dd/MM/yyyy'));
        $this->addElement($field);

        $field = new Submit('submit');
        $field->setLabel('Toevoegen');
        $this->addElement($field);

        $this->setActionsGroup(array('submit'));
    }

    public function populateFromActivity(Activity $activity)
    {
        $this->populate(
            array(
                'name' => $activity->getName(),
                'location' => $activity->getLocation(),
                'date' => $activity->getDate()->format('d/m/Y')
            )
        );
    }
}
