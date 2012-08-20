<?php

namespace CommonBundle\Entity\Counting;

use CommonBundle\Entity\Activity\Activity,
    DateTime,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="CommonBundle\Repository\Counting\Counting")
 * @ORM\Table(name="sale_admin.counting")
 */
class Counting
{
    /**
     * @var integer The ID of the counting
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var CommonBundle\Entity\Activity\Activity The activity of the counting
     *
     * @ORM\ManyToOne(targetEntity="CommonBundle\Entity\Activity\Activity", inversedBy="countings")
     * @ORM\JoinColumn(name="activity", referencedColumnName="id")
     */
    private $activity;

    /**
     * @var string The description of the counting
     *
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @var \DateTime The creation time
     *
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection The cash registers of the counting
     *
     * @ORM\OneToMany(targetEntity="CommonBundle\Entity\Counting\CashRegister", mappedBy="counting", cascade = {"remove"})
     */
    private $cashRegisters;

    /**
     * @param \CommonBundle\Entity\Activity\Activity $activity The activity of the counting
     * @param string $description The description of the counting
     */
    public function __construct(Activity $activity, $description)
    {
        $this->activity = $activity;
        $this->description = $description;
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
     * @return \CommonBundle\Entity\Activity\Activity
     */
    public function getActivity()
    {
        return $this->activity;
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
     * @return \CommonBundle\Entity\Counting\Counting
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getRegisters()
    {
        return $this->cashRegisters;
    }

    /**
     * @return integer
     */
    public function getValue()
    {
        $total = 0;

        foreach($this->cashRegisters as $register)
            $total += $register->getValue();

        return $total;
    }
}
