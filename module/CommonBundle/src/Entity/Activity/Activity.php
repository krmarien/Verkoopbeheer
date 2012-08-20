<?php

namespace CommonBundle\Entity\Activity;

use DateTime;

/**
 * @Entity(repositoryClass="CommonBundle\Repository\Activity\Activity")
 * @Table(name="sale_admin.activity")
 */
class Activity
{
    /**
     * @var integer The ID of the activity
     *
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;

    /**
     * @var string The name of the activity
     *
     * @Column(type="string")
     */
    private $name;

    /**
     * @var string The location of the activity
     *
     * @Column(type="string")
     */
    private $location;

    /**
     * @var \DateTime The data of the activity
     *
     * @Column(type="datetime")
     */
    private $date;

    /**
     * @var string The creation date of the activity
     *
     * @Column(type="datetime")
     */
    private $timestamp;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection The sale items of the activity
     *
     * @OneToMany(targetEntity="CommonBundle\Entity\Stock\Sale", mappedBy="activity")
     */
    private $saleItems;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection The countings of the activity
     *
     * @OneToMany(targetEntity="CommonBundle\Entity\Counting\Counting", mappedBy="activity")
     */
    private $countings;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection The revenues of the activity
     *
     * @OneToMany(targetEntity="CommonBundle\Entity\Activity\Revenue", mappedBy="activity")
     */
    private $revenues;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection The expenses of the activity
     *
     * @OneToMany(targetEntity="CommonBundle\Entity\Activity\Expense", mappedBy="activity")
     */
    private $expenses;

    /**
     * @param string $name The name of the activity
     * @param string $location The location of the activity
     * @param \DateTime $date The date of the activity
     */
    public function __construct($name, $location, DateTime $date)
    {
        $this->name = $name;
        $this->location = $location;
        $this->date = $date;
        $this->timestamp = new DateTime();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
     * @return \CommonBundle\Entity\Activity\Activity
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     *
     * @return \CommonBundle\Entity\Activity\Activity
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return \CommonBundle\Entity\Activity\Activity
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSaleItems()
    {
        return $this->saleItems;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCountings()
    {
        return $this->countings;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getRevenues()
    {
        return $this->revenues;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getExpenses()
    {
        return $this->expenses;
    }

    /**
     * @return integer
     */
    public function getTotalSales()
    {
        $total = 0;
        foreach($this->saleItems as $item)
            $total += $item->getPrice();
        return $total;
    }

    /**
     * @return integer
     */
    public function getGain()
    {
        $total = 0;
        foreach($this->revenues as $revenue)
            $total += $revenue->getValue();
        foreach($this->expenses as $expense)
            $total -= $expense->getValue();
        $total -= $this->getTotalSales();
        return $total;
    }
}
