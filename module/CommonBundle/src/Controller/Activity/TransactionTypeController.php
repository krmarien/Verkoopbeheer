<?php

namespace CommonBundle\Controller\Activity;

use CommonBundle\Component\FlashMessenger\FlashMessage,
    CommonBundle\Entity\Activity\TransactionType,
    CommonBundle\Form\Activity\TransactionType\Add as AddForm,
    Zend\View\Model\ViewModel;

/**
 * TransactionTypeController
 *
 * @author Kristof Mariën <kristof.marien@litus.cc>
 */
class TransactionTypeController extends \CommonBundle\Component\Controller\ActionController
{
    public function addAction()
    {
        if (!($activity = $this->_getActivity()))
            return new ViewModel();

        $form = new AddForm($this->getEntityManager());

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            $form->setData($formData);

            if ($form->isValid()) {
                $transactionType = new TransactionType($formData['name']);

                $this->getEntityManager()->persist($transactionType);
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage(
                    new FlashMessage(
                        FlashMessage::SUCCESS,
                        'Succes',
                        'Het transactie type is succesvol toegevoegd!'
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
