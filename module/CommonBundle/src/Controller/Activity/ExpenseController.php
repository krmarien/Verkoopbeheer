<?php

namespace CommonBundle\Controller\Activity;

use CommonBundle\Component\FlashMessenger\FlashMessage,
    CommonBundle\Entity\Activity\Expense,
    CommonBundle\Form\Activity\Expense\Add as AddForm,
    CommonBundle\Form\Activity\Expense\Edit as EditForm,
    Zend\View\Model\ViewModel;

/**
 * ExpenseController
 *
 * @author Kristof Mariën <kristof.marien@litus.cc>
 */
class ExpenseController extends \CommonBundle\Component\Controller\ActionController
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

                $expense = new Expense(
                    $activity,
                    $transactionType,
                    $formData['description'],
                    $formData['value']
                );

                $this->getEntityManager()->persist($expense);
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage(
                    new FlashMessage(
                        FlashMessage::SUCCESS,
                        'Succes',
                        'De uitgave is succesvol toegevoegd!'
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
        if (!($expense = $this->_getExpense()))
            return new ViewModel();

        $form = new EditForm($this->getEntityManager(), $expense);

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->post()->toArray();

            if ($form->isValid($formData)) {
                $transactionType = $this->getEntityManager()
                    ->getRepository('CommonBundle\Entity\Activity\TransactionType')
                    ->findOneById($formData['type']);

                $expense->setTransactionType($transactionType)
                    ->setDescription($formData['description'])
                    ->setValue($formData['value']);

                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage(
                    new FlashMessage(
                        FlashMessage::SUCCESS,
                        'Succes',
                        'De uitgave is succesvol aangepast!'
                    )
                );

                $this->redirect()->toRoute(
                    'common_activity',
                    array(
                        'action' => 'view',
                        'id' => $expense->getActivity()->getId(),
                    )
                );

                return new ViewModel();
            }
        }

        return new ViewModel(
            array(
                'form' => $form,
                'activity' => $expense->getActivity(),
            )
        );
    }

    public function deleteAction()
    {
        $this->initAjax();

        if (!($expense = $this->_getExpense()))
            return new ViewModel();

        $this->getEntityManager()->remove($expense);
        $this->getEntityManager()->flush();

        return new ViewModel(
            array(
                'result' => array('status' => 'success'),
            )
        );
    }

    public function _getExpense()
    {
        if (null === $this->getParam('id')) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Fout',
                    'Er was geen id opgegeven om de uitgave te identificeren!'
                )
            );

            $this->redirect()->toRoute(
                'common_activity'
            );

            return;
        }

        $expense = $this->getEntityManager()
            ->getRepository('CommonBundle\Entity\Activity\Expense')
            ->findOneById($this->getParam('id'));

        if (null === $expense) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Fout',
                    'Er is geen uitgave gevonden met de opgegeven id!'
                )
            );

            $this->redirect()->toRoute(
                'common_activity'
            );

            return;
        }

        return $expense;
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
