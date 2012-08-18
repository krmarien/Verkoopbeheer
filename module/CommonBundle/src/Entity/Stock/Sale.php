<?php

namespace CommonBundle\Entity\Stock;

use CommonBundle\Entity\Activity\Activity,
    DateTime;

/**
 * @Entity(repositoryClass="CommonBundle\Repository\Stock\Sale")
 * @Table(name="sale_admin.stock_sale")
 */
class Sale
{
    /**
     * @var integer The ID of the sale
     *
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;

    /**
     * @var \CommonBundle\Entity\Stock\Item The stock item of the sale
     *
     * @ManyToOne(targetEntity="CommonBundle\Entity\Stock\Item", inversedBy="sales")
     * @JoinColumn(name="item", referencedColumnName="id")
     */
    private $item;

    /**
     * @var CommonBundle\Entity\Activity\Activity The activity of the sale
     *
     * @ManyToOne(targetEntity="CommonBundle\Entity\Activity\Activity", inversedBy="saleItems")
     * @JoinColumn(name="activity", referencedColumnName="id")
     */
    private $activity;

    /**
     * @var \CommonBundle\Entity\Stock\Purchase The purchase of the sale
     *
     * @ManyToOne(targetEntity="CommonBundle\Entity\Stock\Purchase", inversedBy="sales")
     * @JoinColumn(name="purchase", referencedColumnName="id")
     */
    private $purchase;

    /**
     * @var integer The number of the sale
     *
     * @Column(type="integer")
     */
    private $number;

    /**
     * @var \DateTime The creation date of the sale
     *
     * @Column(type="datetime")
     */
    private $timestamp;

    /**
     * @param \CommonBundle\Entity\Stock\Item $item The stock item of the sale
     * @param \CommonBundle\Entity\Stock\Purchase $purchase The purchase of the sale
     * @param \CommonBundle\Entity\Activity\Activity $activity The activity of the sale
     * @param integer $number The number of the sale
     */
    public function __construct(Item $item, Purchase $purchase, Activity $activity, $number)
    {
        $this->item = $item;
        $this->activity = $activity;
        $this->purchase = $purchase;
        $this->number = $number;
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
     * @return \CommonBundle\Entity\Activity\Activity
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @return \CommonBundle\Entity\Stock\Purchase
     */
    public function getPurchase()
    {
        return $this->purchase;
    }

    /**
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return integer
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return integer
     */
    public function getPrice()
    {
        return $this->getPurchase()->getPrice() / $this->getPurchase()->getNumber() * $this->getNumber();
    }
}