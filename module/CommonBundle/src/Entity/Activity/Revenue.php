<?php

namespace CommonBundle\Entity\Activity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="CommonBundle\Repository\Activity\Revenue")
 * @ORM\Table(name="sale_admin.activity_revenue")
 */
class Revenue
{
    /**
     * @var integer The ID of the revenue
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \CommonBundle\Entity\Activity\Activity The activity of the revenue
     *
     * @ORM\ManyToOne(targetEntity="CommonBundle\Entity\Activity\Activity", inversedBy="revenues")
     * @ORM\JoinColumn(name="activity", referencedColumnName="id")
     */
    private $activity;

    /**
     * @var \CommonBundle\Entity\Activity\TransactionType The transaction type of the revenue
     *
     * @ORM\ManyToOne(targetEntity="CommonBundle\Entity\Activity\TransactionType")
     * @ORM\JoinColumn(name="transaction_type", referencedColumnName="id")
     */
    private $transactionType;

    /**
     * @var string The description of the revenue
     *
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @var integer The value of the revenue
     *
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @param \CommonBundle\Entity\Activity\Activity $activity The activity of the revenue
     * @param \CommonBundle\Entity\Activity\TransactionType $transactionType The transaction type of the revenue
     * @param string $description The description of the revenue
     * @param integer $value The value of the revenue
     */
    public function __construct(Activity $activity, TransactionType $transactionType, $description, $value)
    {
        $this->activity = $activity;
        $this->transactionType = $transactionType;
        $this->description = $description;
        $this->setValue($value);
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \CommonBundle\Entity\Activity\Activity
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @return \CommonBundle\Entity\Activity\TransactionType
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * @param \CommonBundle\Entity\Activity\TransactionType $transactionType
     *
     * @return \CommonBundle\Entity\Activity\Revenue
     */
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return \CommonBundle\Entity\Activity\Revenue
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param integer $value
     *
     * @return \CommonBundle\Entity\Activity\Revenue
     */
    public function setValue($value)
    {
        $this->value = $value*100;
        return $this;
    }
}
