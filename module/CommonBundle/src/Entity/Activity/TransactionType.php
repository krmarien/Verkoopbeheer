<?php

namespace CommonBundle\Entity\Activity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="CommonBundle\Repository\Activity\TransactionType")
 * @ORM\Table(name="sale_admin.activity_transaction_type")
 */
class TransactionType
{
    /**
     * @var integer The ID of the transaction type
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string The name of the transaction type
     *
     * @ORM\Column(type="string")
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
