<?php

namespace CommonBundle\Controller\Stock;

use CommonBundle\Component\FlashMessenger\FlashMessage,
    CommonBundle\Entity\Stock\Sale,
    CommonBundle\Form\Stock\Sale\Add as AddForm,
    DateTime,
    Zend\View\Model\ViewModel;

/**
 * SaleController
 *
 * @author Kristof Mariën <kristof.marien@litus.cc>
 */
class SaleController extends \CommonBundle\Component\Controller\ActionController
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
                $item = $this->getEntityManager()
                    ->getRepository('CommonBundle\Entity\Stock\Item')
                    ->findOneById($formData['item']);

                if ($item->getNumberInStock() < $formData['number']) {
                    $this->flashMessenger()->addMessage(
                        new FlashMessage(
                            FlashMessage::ERROR,
                            'Fout',
                            'Er zijn te weinig items in stock!'
                        )
                    );
                } else {
                    $numberToDo = $formData['number'];
                    foreach($item->getPurchases() as $purchase) {
                        if ($numberToDo <= 0)
                            break;
                        if ($purchase->getNumberInStock() <= 0)
                            continue;

                        $numberAdd = min($purchase->getNumberInStock(), $numberToDo);
                        $sale = new Sale($item, $purchase, $activity, $numberAdd);
                        $this->getEntityManager()->persist($sale);
                        $numberToDo -= $numberAdd;
                    }

                    $this->getEntityManager()->flush();

                    $this->flashMessenger()->addMessage(
                        new FlashMessage(
                            FlashMessage::SUCCESS,
                            'Succes',
                            'De verkoop is succesvol toegevoegd!'
                        )
                    );
                }

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

    public function deleteAction()
    {
        $this->initAjax();

        if (!($sale = $this->_getSale()))
            return new ViewModel();

        $this->getEntityManager()->remove($sale);
        $this->getEntityManager()->flush();

        return new ViewModel(
            array(
                'result' => array('status' => 'success'),
            )
        );
    }

    public function _getSale()
    {
        if (null === $this->getParam('id')) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Fout',
                    'Er was geen id opgegeven om de verkoop te identificeren!'
                )
            );

            $this->redirect()->toRoute(
                'common_stock'
            );

            return;
        }

        $sale = $this->getEntityManager()
            ->getRepository('CommonBundle\Entity\Stock\Sale')
            ->findOneById($this->getParam('id'));

        if (null === $sale) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Fout',
                    'Er is geen verkoop gevonden met de opgegeven id!'
                )
            );

            $this->redirect()->toRoute(
                'common_stock'
            );

            return;
        }

        return $sale;
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
