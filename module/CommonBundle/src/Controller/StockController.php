<?php

namespace CommonBundle\Controller;

use CommonBundle\Component\FlashMessenger\FlashMessage,
    CommonBundle\Entity\Stock\Item,
    CommonBundle\Form\Stock\Item\Add as AddForm,
    CommonBundle\Form\Stock\Item\Edit as EditForm,
    Zend\View\Model\ViewModel;

/**
 * StockController
 *
 * @author Kristof Mariën <kristof.marien@litus.cc>
 */
class StockController extends \CommonBundle\Component\Controller\ActionController
{
    public function manageAction()
    {
        $items = $this->getEntityManager()
            ->getRepository('CommonBundle\Entity\Stock\Item')
            ->findAll();

        return new ViewModel(
            array(
                'items' => $items,
            )
        );
    }

    public function addAction()
    {
        $form = new AddForm();

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->post()->toArray();

            if ($form->isValid($formData)) {
                $item = new Item(
                    $formData['name']
                );
                $this->getEntityManager()->persist($item);
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage(
                    new FlashMessage(
                        FlashMessage::SUCCESS,
                        'Succes',
                        'Het stock item is succesvol toegevoegd!'
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

    public function editAction()
    {
        if (!($item = $this->_getItem()))
            return new ViewModel();

        $form = new EditForm($item);

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->post()->toArray();

            if ($form->isValid($formData)) {
                $item->setName($formData['name']);

                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage(
                    new FlashMessage(
                        FlashMessage::SUCCESS,
                        'Succes',
                        'Het stock item is succesvol aangepast!'
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

    public function viewAction()
    {
        if (!($item = $this->_getItem()))
            return new ViewModel();

        return new ViewModel(
            array(
                'item' => $item,
            )
        );
    }

    public function _getItem()
    {
        if (null === $this->getParam('id')) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Fout',
                    'Er was geen id opgegeven om het stock item te identificeren!'
                )
            );

            $this->redirect()->toRoute(
                'common_stock'
            );

            return;
        }

        $item = $this->getEntityManager()
            ->getRepository('CommonBundle\Entity\Stock\Item')
            ->findOneById($this->getParam('id'));

        if (null === $item) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Fout',
                    'Er is geen stock item gevonden met de opgegeven id!'
                )
            );

            $this->redirect()->toRoute(
                'common_stock'
            );

            return;
        }

        return $item;
    }
}
