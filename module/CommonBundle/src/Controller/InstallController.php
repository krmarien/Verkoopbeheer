<?php

namespace CommonBundle\Controller;

use CommonBundle\Entity\Counting\MoneyUnit;

/**
 * InstallController
 *
 * @author Kristof Mariën <kristof.marien@litus.cc>
 */
class InstallController extends \CommonBundle\Component\Controller\ActionController\InstallController
{
    protected function _initConfig()
    {
        $units = array(
            1,
            2,
            5,
            10,
            20,
            50,
            100,
            200,
            500,
            1000,
            2000,
            5000,
            10000,
            20000,
            50000,
        );

        foreach($units as $value) {
            $unit = $this->getEntityManager()
                ->getRepository('CommonBundle\Entity\Counting\MoneyUnit')
                ->findOneByValue($value);

            if (null === $unit) {
                $unit = new MoneyUnit($value);
                $this->getEntityManager()->persist($unit);
            }
        }

        $this->getEntityManager()->flush();
    }
}