<?php

namespace CommonBundle\Entity\Counting;

/**
 * @Entity(repositoryClass="CommonBundle\Repository\Counting\CashRegister")
 * @Table(name="sale_admin.counting_cash_register")
 */
class CashRegister
{
    /**
     * @var integer The ID of the cash register
     *
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;

    /**
     * @var \CommonBundle\Entity\Counting\Counting The counting of the cash register
     *
     * @ManyToOne(targetEntity="CommonBundle\Entity\Counting\Counting", inversedBy="cashRegisters")
     * @JoinColumn(name="counting", referencedColumnName="id")
     */
    private $counting;

    /**
     * @var string The name of the cash register
     *
     * @Column(type="string")
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection The number of money units of the cash register
     *
     * @OneToMany(targetEntity="CommonBundle\Entity\Counting\NumberMoneyUnit", mappedBy="cashRegister", cascade={"remove"})
     */
    private $numberMoneyUnits;

    /**
     * @param \CommonBundle\Entity\Counting\Counting $counting The counting of the cash register
     * @param string $name The name of the cash register
     */
    public function __construct(Counting $counting, $name)
    {
        $this->counting = $counting;
        $this->name = $name;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \CommonBundle\Entity\Counting\Counting
     */
    public function getCounting()
    {
        return $this->counting;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return \CommonBundle\Entity\Counting\CashRegister
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getNumberMoneyUnits()
    {
        return $this->numberMoneyUnits;
    }

    /**
     * @param \CommonBundle\Entity\Counting\MoneyUnit $unit
     *
     * @return \CommonBundle\Entity\Counting\NumberMoneyUnit
     */
    public function getNumberMoneyUnitByUnit(MoneyUnit $unit)
    {
        foreach($this->numberMoneyUnits as $number) {
            if ($number->getUnit() == $unit)
                return $number;
        }
    }

    /**
     * @return integer
     */
    public function getValue()
    {
        $total = 0;

        foreach($this->numberMoneyUnits as $number)
            $total += $number->getNumber() * $number->getUnit()->getValue();

        return $total;
    }
}