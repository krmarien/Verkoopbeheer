<?php

namespace CommonBundle\Entity\Stock;

use DateTime;

/**
 * @Entity(repositoryClass="CommonBundle\Repository\Stock\Purchase")
 * @Table(name="sale_admin.stock_purchase")
 */
class Purchase
{
    /**
     * @var integer The ID of the purchase
     *
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;

    /**
     * @var \CommonBundle\Entity\Stock\Item The stock item of the purchase
     *
     * @ManyToOne(targetEntity="CommonBundle\Entity\Stock\Item", inversedBy="purchases")
     * @JoinColumn(name="item", referencedColumnName="id")
     */
    private $item;

    /**
     * @var integer The price of the purchase
     *
     * @Column(type="integer")
     */
    private $price;

    /**
     * @var integer The number of items in the purchase
     *
     * @Column(type="integer")
     */
    private $number;

    /**
     * @var \DateTime The date of the purchase
     *
     * @Column(type="datetime")
     */
    private $date;

    /**
     * @var \DateTime The creation date of the purchase
     *
     * @Column(type="datetime")
     */
    private $timestamp;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection The sales of the purchase
     *
     * @OneToMany(targetEntity="CommonBundle\Entity\Stock\Sale", mappedBy="purchase")
     */
    private $sales;

    /**
     * @param \CommonBundle\Entity\Stock\Item $item The stock item of the purchase
     * @param $integer $price The price of the purchase
     * @param $integer $number The number of items of the purchase
     * @param \DateTime $date The date of the purchase
     */
    public function __construct(Item $item, $price, $number, DateTime $date)
    {
        $this->item = $item;
        $this->price = $price*100;
        $this->number = $number;
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
     * @return \CommonBundle\Entity\Stock\Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return integer
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * @return integer
     */
    public function getNumberSold()
    {
        $number = 0;
        foreach($this->sales as $sale)
            $number += $sale->getNumber();
        return $number;
    }

    /**
     * @return integer
     */
    public function getNumberInStock()
    {
        return $this->number - $this->getNumberSold();
    }
}