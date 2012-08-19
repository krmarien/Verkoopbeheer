<?php

namespace CommonBundle\Controller\Activity;

use CommonBundle\Component\FlashMessenger\FlashMessage,
    CommonBundle\Entity\Activity\Revenue,
    CommonBundle\Form\Activity\Revenue\Add as AddForm,
    CommonBundle\Form\Activity\Revenue\Edit as EditForm,
    Zend\View\Model\ViewModel;

/**
 * RevenueController
 *
 * @author Kristof Mariën <kristof.marien@litus.cc>
 */
class RevenueController extends \CommonBundle\Component\Controller\ActionController
{
    public function addAction()
    {
        if (!($activity = $this->_getActivity()))
            return new ViewModel();

        $form = new AddForm($this->getEntityManager());

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->post()->toArray();

            if ($form->isValid($formData)) {
                $transactionType = $this->getEntityManager()
                    ->getRepository('CommonBundle\Entity\Activity\TransactionType')
                    ->findOneById($formData['type']);

                $revenue = new Revenue(
                    $activity,
                    $transactionType,
                    $formData['description'],
                    $formData['value']
                );

                $this->getEntityManager()->persist($revenue);
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage(
                    new FlashMessage(
                        FlashMessage::SUCCESS,
                        'Succes',
                        'De inkomst is succesvol toegevoegd!'
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
        if (!($revenue = $this->_getRevenue()))
            return new ViewModel();

        $form = new EditForm($this->getEntityManager(), $revenue);

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->post()->toArray();

            if ($form->isValid($formData)) {
                $transactionType = $this->getEntityManager()
                    ->getRepository('CommonBundle\Entity\Activity\TransactionType')
                    ->findOneById($formData['type']);

                $revenue->setTransactionType($transactionType)
                    ->setDescription($formData['description'])
                    ->setValue($formData['value']);

                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage(
                    new FlashMessage(
                        FlashMessage::SUCCESS,
                        'Succes',
                        'De inkomst is succesvol aangepast!'
                    )
                );

                $this->redirect()->toRoute(
                    'common_activity',
                    array(
                        'action' => 'view',
                        'id' => $revenue->getActivity()->getId(),
                    )
                );

                return new ViewModel();
            }
        }

        return new ViewModel(
            array(
                'form' => $form,
                'activity' => $revenue->getActivity(),
            )
        );
    }

    public function deleteAction()
    {
        $this->initAjax();

        if (!($revenue = $this->_getRevenue()))
            return new ViewModel();

        $this->getEntityManager()->remove($revenue);
        $this->getEntityManager()->flush();

        return new ViewModel(
            array(
                'result' => array('status' => 'success'),
            )
        );
    }

    public function _getRevenue()
    {
        if (null === $this->getParam('id')) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Fout',
                    'Er was geen id opgegeven om de inkomst te identificeren!'
                )
            );

            $this->redirect()->toRoute(
                'common_activity'
            );

            return;
        }

        $revenue = $this->getEntityManager()
            ->getRepository('CommonBundle\Entity\Activity\Revenue')
            ->findOneById($this->getParam('id'));

        if (null === $revenue) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Fout',
                    'Er is geen inkomst gevonden met de opgegeven id!'
                )
            );

            $this->redirect()->toRoute(
                'common_activity'
            );

            return;
        }

        return $revenue;
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
