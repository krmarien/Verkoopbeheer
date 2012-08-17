<?php
namespace CommonBundle\Component\Validator;

use Doctrine\ORM\EntityManager;

/**
 * Matches the given nav name against the database to check whether it is
 * unique or not.
 *
 * @author Kristof Mariën <kristof.marien@litus.cc>
 */
class UniqueNavName extends \Zend\Validator\AbstractValidator
{
    const NOT_VALID = 'notValid';

	/**
	 * @var \Doctrine\ORM\EntityManager The EntityManager instance
	 */
	private $_entityManager = null;

    /**
     * @var array The error messages
     */
    protected $_messageTemplates = array(
        self::NOT_VALID => 'The navigation already exists'
    );

	/**
	 * @param \Doctrine\ORM\EntityManager $entityManager The EntityManager instance
	 * @param mixed $opts The validator's options
	 */
	public function __construct(EntityManager $entityManager, $opts = null)
	{
		parent::__construct($opts);
		
		$this->_entityManager = $entityManager;
	}

    /**
     * Returns true if no matching record is found in the database.
     *
     * @param string $value The value of the field that will be validated
     * @param array $context The context of the field that will be validated
     * @return boolean
     */
    public function isValid($value, $context = null)
    {
        $this->setValue($value);

		$nav = $this->_entityManager
			->getRepository('CommonBundle\Entity\Nav\Nav')
			->findOneByName($value);
		
        if (null === $nav)
            return true;

        $this->error(self::NOT_VALID);
        
        return false;
    }
}
