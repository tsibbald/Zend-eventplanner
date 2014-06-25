<?php
namespace Social\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Social\Model\Group; 
use Social\Model\Member;         // <-- Add this importt
use Zend\View\Model\JsonModel;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;

class SocialController extends AbstractActionController 
{
    protected $MemberTable;
    protected $acceptMapping = array(
        'Zend\View\Model\ViewModel' => array(
            'text/html'
        ),
        'Zend\View\Model\JsonModel' => array(
            'application/json'
        )
    );

    public function indexAction()
    {
       
        $paginator = $this->getMemberTable()->fetchAll(true);
    // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
    // set the number of items per page to 10
        $paginator->setItemCountPerPage(10);

        return new ViewModel(array(
         'paginator' => $paginator
        ));


    }
    public function getMemberTable()
    {
        if (!$this->MemberTable) {
            $sm = $this->getServiceLocator();
            $this->MemberTable = $sm->get('Social\Model\MemberTable');
        }
        return $this->MemberTable;
    }
    public function filterAction()
    {   
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            $term = $post->term;
            $table = 'member';
            $row = $post->memberrow;
            $viewModel = new JsonModel($this->getMemberTable()->filter($term, $table, $row));
            return $viewModel;
        }
    }
    public function typeaheadAction()
    {   
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            $term = $post->query;
            $table = 'member';
            $row = 'username';
            $result = $this->getMemberTable()->filter($term, $table, $row);
            $a = Array();
            foreach ($result as $key) {
               $a[] =$key['username'];
            }
            $viewModel = new JsonModel($a);
            return $viewModel;
        }
    }
   


  
}