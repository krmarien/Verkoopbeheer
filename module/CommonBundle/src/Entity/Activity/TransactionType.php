<?php

namespace CommonBundle\Entity\Activity;

/**
 * @Entity(repositoryClass="CommonBundle\Repository\Activity\TransactionType")
 * @Table(name="sale_admin.activity_transaction_type")
 */
class TransactionType
{
    /**
     * @var integer The ID of the transaction type
     *
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;

    /**
     * @var string The name of the transaction type
     *
     * @Column(type="string")
     */
    private $name;

    /**
     * @param string $name The name of the transaction type
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
}