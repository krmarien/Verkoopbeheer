<?php
namespace CommonBundle\Component\Validator;

use Zend\Date\Date;

/**
 * Matches the date to a week day.
 *
 * @author Kristof Mariën <kristof.marien@litus.cc>
 */
class Day extends \Zend\Validator\AbstractValidator
{
    const NOT_VALID = 'notValid';
    
    /**
     * @var integer The day of the week
     */
    private $_day;
    
    /**
     * @var integer The format for the date
     */
    private $_format;

    /**
     * @var array The error messages
     */
    protected $_messageTemplates = array(
        self::NOT_VALID => 'The date must be a %day%'
    );
    
    /**
     * @var array
     */
    protected $_messageVariables = array(
        'day' => array('options' => 'day'),
    );

    protected $options = array(
        'day'      => null,
    );

	/**
	 * @param integer $day The day of the week
	 * @param string $format The date format
	 * @param mixed $opts The validator's options
	 */
	public function __construct($day, $format, $opts = null)
	{
		parent::__construct($opts);
		
		$this->_day = $day;
		$this->_format = $format;
		
		$date = new Date($day, 'e');
		$this->options['day'] = $date->toString('EEEE');
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

		$date = \DateTime::createFromFormat($this->_format, $value);

        if ($date && $date->format('N') == $this->_day)
            return true;

        $this->error(self::NOT_VALID);
        
        return false;
    }
}
