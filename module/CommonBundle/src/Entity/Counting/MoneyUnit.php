<?php

namespace CommonBundle\Entity\Counting;

/**
 * @Entity(repositoryClass="CommonBundle\Repository\Counting\MoneyUnit")
 * @Table(name="sale_admin.counting_money_unit")
 */
class MoneyUnit
{
    /**
     * @var integer The ID of the money unit
     *
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;

    /**
     * @var integer The value of the money unit
     *
     * @Column(type="integer")
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
