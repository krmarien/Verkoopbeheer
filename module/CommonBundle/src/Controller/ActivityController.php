<?php

namespace CommonBundle\Controller;

use CommonBundle\Component\FlashMessenger\FlashMessage,
    CommonBundle\Entity\Activity\Activity,
    CommonBundle\Form\Activity\Add as AddForm,
    CommonBundle\Form\Activity\Edit as EditForm,
    DateTime,
    Zend\View\Model\ViewModel;

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

    public function addAction()
    {
        $form = new AddForm();

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            $form->setData($formData);

            if ($form->isValid()) {
                $activity = new Activity(
                    $formData['name'],
                    $formData['location'],
                    DateTime::createFromFormat('d#m#Y', $formData['date'])
                );
                $this->getEntityManager()->persist($activity);
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage(
                    new FlashMessage(
                        FlashMessage::SUCCESS,
                        'Succes',
                        'De activiteit is succesvol toegevoegd!'
                    )
                );

                $this->redirect()->toRoute(
                    'common_activity'
                );

                return new ViewModel();
            }
        }

        return new ViewModel(
            array(
                'form' => $form,
            )
        );
    }

    public function editAction()
    {
        if (!($activity = $this->_getActivity()))
            return new ViewModel();

        $form = new EditForm($activity);

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            $form->setData($formData);

            if ($form->isValid()) {
                $activity->setName($formData['name'])
                    ->setLocation($formData['location'])
                    ->setDate(DateTime::createFromFormat('d#m#Y', $formData['date']));

                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage(
                    new FlashMessage(
                        FlashMessage::SUCCESS,
                        'Succes',
                        'De activiteit is succesvol aangepast!'
                    )
                );

                $this->redirect()->toRoute(
                    'common_activity'
                );

                return new ViewModel();
            }
        }

        return new ViewModel(
            array(
                'form' => $form,
            )
        );
    }

    public function viewAction()
    {
        if (!($activity = $this->_getActivity()))
            return new ViewModel();

        return new ViewModel(
            array(
                'activity' => $activity,
            )
        );
    }

    public function _getActivity()
    {
        if (null === $this->getParam('id')) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Fout',
                    'Er was geen id opgegeven om de activiteit te identificeren!'
                )
            );

            $this->redirect()->toRoute(
                'common_activity'
            );

            return;
        }

        $activity = $this->getEntityManager()
            ->getRepository('CommonBundle\Entity\Activity\Activity')
            ->findOneById($this->getParam('id'));

        if (null === $activity) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Fout',
                    'Er is geen activiteit gevonden met de opgegeven id!'
                )
            );

            $this->redirect()->toRoute(
                'common_activity'
            );

            return;
        }

        return $activity;
    }
}
