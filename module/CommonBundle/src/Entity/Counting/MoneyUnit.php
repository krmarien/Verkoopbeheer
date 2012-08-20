<?php

namespace CommonBundle\Entity\Counting;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="CommonBundle\Repository\Counting\MoneyUnit")
 * @ORM\Table(name="sale_admin.counting_money_unit")
 */
class MoneyUnit
{
    /**
     * @var integer The ID of the money unit
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var integer The value of the money unit
     *
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @param integer $value The value of the money unit
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }
}
