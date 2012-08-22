<?php

namespace CommonBundle\Controller\Counting;

use CommonBundle\Component\FlashMessenger\FlashMessage,
    CommonBundle\Entity\Counting\CashRegister,
    CommonBundle\Entity\Counting\NumberMoneyUnit,
    CommonBundle\Form\Counting\Register\Add as AddForm,
    CommonBundle\Form\Counting\Register\Edit as EditForm,
    Zend\View\Model\ViewModel;

/**
 * RegisterController
 *
 * @author Kristof Mariën <kristof.marien@litus.cc>
 */
class RegisterController extends \CommonBundle\Component\Controller\ActionController
{
    public function addAction()
    {
        if (!($counting = $this->_getCounting()))
            return new ViewModel();

        $form = new AddForm($this->getEntityManager());

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            $form->setData($formData);

            if ($form->isValid()) {
                $register = new CashRegister($counting, $formData['name']);

                $units = $this->getEntityManager()
                    ->getRepository('CommonBundle\Entity\Counting\MoneyUnit')
                    ->findAll();
                foreach($units as $unit) {
                    $this->getEntityManager()->persist(new NumberMoneyUnit($register, $unit, $formData['unit_' . $unit->getId()]));
                }

                $this->getEntityManager()->persist($register);
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage(
                    new FlashMessage(
                        FlashMessage::SUCCESS,
                        'Succes',
                        'De kassa is succesvol toegevoegd!'
                    )
                );

                $this->redirect()->toRoute(
                    'common_counting',
                    array(
                        'action' => 'view',
                        'id' => $counting->getId(),
                    )
                );

                return new ViewModel();
            }
        }

        return new ViewModel(
            array(
                'form' => $form,
                'counting' => $counting,
            )
        );
    }

    public function editAction()
    {
        if (!($register = $this->_getRegister()))
            return new ViewModel();

        $form = new EditForm($register, $this->getEntityManager());

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            $form->setData($formData);

            if ($form->isValid()) {
                $register->setName($formData['name']);

                $units = $this->getEntityManager()
                    ->getRepository('CommonBundle\Entity\Counting\MoneyUnit')
                    ->findAll();
                foreach($units as $unit) {
                    $number = $register->getNumberMoneyUnitByUnit($unit);
                    if ($number) {
                        $number->setNumber($formData['unit_' . $unit->getId()]);
                    } else {
                        $this->getEntityManager()->persist(new NumberMoneyUnit($register, $unit, $formData['unit_' . $unit->getId()]));
                    }
                }

                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage(
                    new FlashMessage(
                        FlashMessage::SUCCESS,
                        'Succes',
                        'De kassa is succesvol aangepast!'
                    )
                );

                $this->redirect()->toRoute(
                    'common_counting',
                    array(
                        'action' => 'view',
                        'id' => $register->getCounting()->getId(),
                    )
                );

                return new ViewModel();
            }
        }

        return new ViewModel(
            array(
                'form' => $form,
                'counting' => $register->getCounting(),
            )
        );
    }

    public function viewAction()
    {
        if (!($register = $this->_getRegister()))
            return new ViewModel();

        return new ViewModel(
            array(
                'register' => $register,
                'counting' => $register->getCounting(),
            )
        );
    }

    public function deleteAction()
    {
        $this->initAjax();

        if (!($register = $this->_getRegister()))
            return new ViewModel();

        $this->getEntityManager()->remove($register);
        $this->getEntityManager()->flush();

        return new ViewModel(
            array(
                'result' => array('status' => 'success'),
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

    public function _getRegister()
    {
        if (null === $this->getParam('id')) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Fout',
                    'Er was geen id opgegeven om de kassa te identificeren!'
                )
            );

            $this->redirect()->toRoute(
                'common_activity'
            );

            return;
        }

        $register = $this->getEntityManager()
            ->getRepository('CommonBundle\Entity\Counting\CashRegister')
            ->findOneById($this->getParam('id'));

        if (null === $register) {
            $this->flashMessenger()->addMessage(
                new FlashMessage(
                    FlashMessage::ERROR,
                    'Fout',
                    'Er is geen kassa gevonden met de opgegeven id!'
                )
            );

            $this->redirect()->toRoute(
                'common_activity'
            );

            return;
        }

        return $register;
    }
}
