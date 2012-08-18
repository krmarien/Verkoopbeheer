<?php

namespace CommonBundle\Controller\Stock;

use CommonBundle\Component\FlashMessenger\FlashMessage,
    CommonBundle\Entity\Stock\Purchase,
    CommonBundle\Form\Stock\Purchase\Add as AddForm,
    DateTime,
    Zend\View\Model\ViewModel;

/**
 * PurchaseController
 *
 * @author Kristof Mariën <kristof.marien@litus.cc>
 */
class PurchaseController extends \CommonBundle\Component\Controller\ActionController
{
    public function addAction()
    {
        $form = new AddForm($this->getEntityManager());

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->post()->toArray();

            if ($form->isValid($formData)) {
                $item = $this->getEntityManager()
                    ->getRepository('CommonBundle\Entity\Stock\Item')
                    ->findOneById($formData['item']);

                $purchase = new Purchase(
                    $item,
                    $formData['price'],
                    $formData['number'],
                    DateTime::createFromFormat('d#m#Y', $formData['date'])
                );
                $this->getEntityManager()->persist($purchase);
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage(
                    new FlashMessage(
                        FlashMessage::SUCCESS,
                        'Succes',
                        'De aankoop is succesvol toegevoegd!'
                    )
                );

                $this->redirect()->toRoute(
                    'common_stock'
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

    public function deleteAction()
    {
        $this->initAjax();

        if (!($purchase = $this->_getPurchase()))
            return new ViewModel();

        $this->getEntityManager()->remove($purchase);
        $this->getEntityManager()->flush();

        return new ViewModel(
            array(
                'result' => array('status' => 'success'),
            )
        );
    }

    public function _getPurchase()
    {
        if (null === $this->getParam('id')) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Fout',
                    'Er was geen id opgegeven om de aankoop te identificeren!'
                )
            );

            $this->redirect()->toRoute(
                'common_stock'
            );

            return;
        }

        $purchase = $this->getEntityManager()
            ->getRepository('CommonBundle\Entity\Stock\Purchase')
            ->findOneById($this->getParam('id'));

        if (null === $purchase) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Fout',
                    'Er is geen aankoop gevonden met de opgegeven id!'
                )
            );

            $this->redirect()->toRoute(
                'common_stock'
            );

            return;
        }

        return $purchase;
    }
}
