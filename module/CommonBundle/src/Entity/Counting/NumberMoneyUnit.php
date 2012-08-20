<?php

namespace CommonBundle\Entity\Counting;

/**
 * @Entity(repositoryClass="CommonBundle\Repository\Counting\NumberMoneyUnit")
 * @Table(name="sale_admin.counting_number_money_unit")
 */
class NumberMoneyUnit
{
    /**
     * @var integer The ID of the number of a money unit
     *
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;

    /**
     * @var \CommonBundle\Entity\Counting\CashRegister The cashregister of the number of a money unit
     *
     * @ManyToOne(targetEntity="CommonBundle\Entity\Counting\CashRegister", inversedBy="numberMoneyUnits")
     * @JoinColumn(name="cash_register", referencedColumnName="id")
     */
    private $cashRegister;

    /**
     * @var \CommonBundle\Entity\Counting\MoneyUnit The unit of the number
     *
     * @ManyToOne(targetEntity="CommonBundle\Entity\Counting\MoneyUnit")
     * @JoinColumn(name="unit", referencedColumnName="id")
     */
    private $unit;

    /**
     * @var integer The number
     *
     * @Column(type="integer")
     */
    private $number;

    /**
     * @param \CommonBundle\Entity\Counting\CashRegister $register The cash register
     * @param \CommonBundle\Entity\Counting\MoneyUnit $unit The unit
     * @param integer $number The number
     */
    public function __construct(CashRegister $register, MoneyUnit $unit, $number)
    {
        $this->cashRegister = $register;
        $this->unit = $unit;
        $this->number = $number;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \CommonBundle\Entity\Counting\MoneyUnit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param integer
     *
     * @return \CommonBundle\Entity\Counting\NumberMoneyUnit
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return integer
     */
    public function getValue()
    {
        return $this->number * $this->unit->getValue();
    }
}
