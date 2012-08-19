<?php

namespace CommonBundle\Entity\Activity;

/**
 * @Entity(repositoryClass="CommonBundle\Repository\Activity\Expense")
 * @Table(name="sale_admin.activity_expense")
 */
class Expense
{
    /**
     * @var integer The ID of the expense
     *
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;

    /**
     * @var \CommonBundle\Entity\Activity\Activity The activity of the expense
     *
     * @ManyToOne(targetEntity="CommonBundle\Entity\Activity\Activity", inversedBy="expenses")
     * @JoinColumn(name="activity", referencedColumnName="id")
     */
    private $activity;

    /**
     * @var \CommonBundle\Entity\Activity\TransactionType The transaction type of the expense
     *
     * @ManyToOne(targetEntity="CommonBundle\Entity\Activity\TransactionType")
     * @JoinColumn(name="transaction_type", referencedColumnName="id")
     */
    private $transactionType;

    /**
     * @var string The description of the expense
     *
     * @Column(type="string")
     */
    private $description;

    /**
     * @var integer The value of the expense
     *
     * @Column(type="integer")
     */
    private $value;

    /**
     * @param \CommonBundle\Entity\Activity\Activity $activity The activity of the expense
     * @param \CommonBundle\Entity\Activity\TransactionType $transactionType The transaction type of the expense
     * @param string $description The description of the expense
     * @param integer $value The value of the expense
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
     * @return \CommonBundle\Entity\Activity\Expense
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
     * @return \CommonBundle\Entity\Activity\Expense
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
     * @return \CommonBundle\Entity\Activity\Expense
     */
    public function setValue($value)
    {
        $this->value = $value*100;
        return $this;
    }
}