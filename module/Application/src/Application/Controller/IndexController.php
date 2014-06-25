<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    	const ROUTE_LOGIN        = 'zfcuser/login';
    	
    public function indexAction()
    {

       
    	if (!$this->zfcUserAuthentication()->hasIdentity()) {

            return $this->redirect()->toRoute(static::ROUTE_LOGIN);
        }

        return new ViewModel();
    }
}
