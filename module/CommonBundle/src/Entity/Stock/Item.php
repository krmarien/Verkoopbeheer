<?php

namespace CommonBundle\Entity\Stock;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="CommonBundle\Repository\Stock\Item")
 * @ORM\Table(name="sale_admin.stock_item")
 */
class Item
{
    /**
     * @var integer The ID of the stock item
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string The name of the stock item
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection The purchases of the stock item
     *
     * @ORM\OneToMany(targetEntity="CommonBundle\Entity\Stock\Purchase", mappedBy="item")
     * @ORM\OrderBy({"timestamp" = "ASC"})
     */
    private $purchases;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection The sales of the stock item
     *
     * @ORM\OneToMany(targetEntity="CommonBundle\Entity\Stock\Sale", mappedBy="item")
     * @ORM\OrderBy({"timestamp" = "ASC"})
     */
    private $sales;

    /**
     * @param string $name The name of the stock item
     */
    public function __construct($name)
    {
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return \CommonBundle\Entity\Stock\Item
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getPurchases()
    {
        return $this->purchases;
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
    public function getTotalValue()
    {
        $value = 0;
        foreach($this->purchases as $purchase) {
            if ($purchase->getNumberInStock() > 0)
                $value += $purchase->getNumberInStock() * $purchase->getPrice() / $purchase->getNumber();
        }
        return $value;
    }

    /**
     * @return integer
     */
    public function getNumberInStock()
    {
        $number = 0;
        foreach($this->purchases as $purchase) {
            $number += $purchase->getNumberInStock();
        }
        return $number;
    }
}
