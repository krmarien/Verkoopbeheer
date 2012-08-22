<?php

namespace CommonBundle\Controller\Counting;

use CommonBundle\Component\FlashMessenger\FlashMessage,
    CommonBundle\Entity\Counting\Counting,
    CommonBundle\Form\Counting\Add as AddForm,
    CommonBundle\Form\Counting\Edit as EditForm,
    Zend\View\Model\ViewModel;

/**
 * CountingController
 *
 * @author Kristof Mariën <kristof.marien@litus.cc>
 */
class CountingController extends \CommonBundle\Component\Controller\ActionController
{
    public function addAction()
    {
        if (!($activity = $this->_getActivity()))
            return new ViewModel();

        $form = new AddForm();

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            $form->setData($formData);

            if ($form->isValid()) {
                $counting = new Counting(
                    $activity,
                    $formData['name']
                );
                $this->getEntityManager()->persist($counting);
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage(
                    new FlashMessage(
                        FlashMessage::SUCCESS,
                        'Succes',
                        'De telling is succesvol toegevoegd!'
                    )
                );

                $this->redirect()->toRoute(
                    'common_activity',
                    array(
                        'action' => 'view',
                        'id' => $activity->getId(),
                    )
                );

                return new ViewModel();
            }
        }

        return new ViewModel(
            array(
                'form' => $form,
                'activity' => $activity,
            )
        );
    }

    public function editAction()
    {
        if (!($counting = $this->_getCounting()))
            return new ViewModel();

        $form = new EditForm($counting);

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            $form->setData($formData);

            if ($form->isValid()) {
                $counting->setDescription($formData['name']);

                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage(
                    new FlashMessage(
                        FlashMessage::SUCCESS,
                        'Succes',
                        'De telling is succesvol aangepast!'
                    )
                );

                $this->redirect()->toRoute(
                    'common_activity',
                    array(
                        'action' => 'view',
                        'id' => $counting->getActivity()->getId(),
                    )
                );

                return new ViewModel();
            }
        }

        return new ViewModel(
            array(
                'form' => $form,
                'activity' => $counting->getActivity(),
            )
        );
    }

    public function deleteAction()
    {
        $this->initAjax();

        if (!($counting = $this->_getCounting()))
            return new ViewModel();

        $this->getEntityManager()->remove($counting);
        $this->getEntityManager()->flush();

        return new ViewModel(
            array(
                'result' => array('status' => 'success'),
            )
        );
    }

    public function viewAction()
    {
        if (!($counting = $this->_getCounting()))
            return new ViewModel();

        return new ViewModel(
            array(
                'activity' => $counting->getActivity(),
                'counting' => $counting,
            )
        );
    }

    public function _getCounting()
    {
        if (null === $this->getParam('id')) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Fout',
                    'Er was geen id opgegeven om de telling te identificeren!'
                )
            );

            $this->redirect()->toRoute(
                'common_activity'
            );

            return;
        }

        $counting = $this->getEntityManager()
            ->getRepository('CommonBundle\Entity\Counting\Counting')
            ->findOneById($this->getParam('id'));

        if (null === $counting) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Fout',
                    'Er is geen telling gevonden met de opgegeven id!'
                )
            );

            $this->redirect()->toRoute(
                'common_activity'
            );

            return;
        }

        return $counting;
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
