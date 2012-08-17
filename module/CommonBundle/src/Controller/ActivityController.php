<?php

namespace CommonBundle\Controller;

use Zend\View\Model\ViewModel;

/**
 * ActivityController
 *
 * @author Kristof Mariën <kristof.marien@litus.cc>
 */
class ActivityController extends \CommonBundle\Component\Controller\ActionController
{
    public function manageAction()
    {
        $activities = $this->getEntityManager()
            ->getRepository('CommonBundle\Entity\Activity\Activity')
            ->findAll();

        $total = 0;
        foreach($activities as $activity)
            $total += $activity->getGain();

        return new ViewModel(
            array(
                'activities' => $activities,
                'total' => $total,
            )
        );
    }
}
