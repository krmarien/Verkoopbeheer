<?php
/**
 * Litus is a project by a group of students from the K.U.Leuven. The goal is to create
 * various applications to support the IT needs of student unions.
 *
 * @author Karsten Daemen <karsten.daemen@litus.cc>
 * @author Bram Gotink <bram.gotink@litus.cc>
 * @author Pieter Maene <pieter.maene@litus.cc>
 * @author Kristof Mariën <kristof.marien@litus.cc>
 * @author Michiel Staessen <michiel.staessen@litus.cc>
 * @author Alan Szepieniec <alan.szepieniec@litus.cc>
 *
 * @license http://litus.cc/LICENSE
 */
 
namespace CommonBundle\Component\Controller\ActionController;

use CommonBundle\Entity\General\Config,
    Exception,
    Zend\View\Model\ViewModel;

/**
 * This abstract function should be implemented by all controller that want to provide
 * installation functionality for a bundle.
 *
 * @author Pieter Maene <pieter.maene@litus.cc>
 */
abstract class InstallController extends \CommonBundle\Component\Controller\ActionController
{
    /**
     * Running all installation methods.
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_initConfig();

        return new ViewModel(
            array(
                'installerReady' => true,
            )
        );
    }

    /**
     * Initiliazes all configuration values for the bundle.
     *
     * @return void
     */
    abstract protected function _initConfig();

    /**
     * Install the config values
     *
     * @param array $configs
     */
    protected function _installConfig($configs)
    {
        foreach($configs as $item) {
            try {
                $config = $this->getEntityManager()
                    ->getRepository('CommonBundle\Entity\General\Config')
                    ->getConfigValue($item['key']);
            } catch(Exception $e) {
                $config = new Config($item['key'], $item['value']);
                $config->setDescription($item['description']);
                $this->getEntityManager()->persist($config);
            }
        }
        $this->getEntityManager()->flush();
    }
}
