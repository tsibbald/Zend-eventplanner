<?php
namespace Calender\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Sql,
Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Expression;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;

class UserTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

    public function getUserId(array $useridArray)
    {
        
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new Sql($adapter);
        $select = $sql->select('id');
        $select->from(array('u' => 'User'));
        $select->where('user_id IN'. $useridArray);
        $statement = $sql->getSqlStringForSqlObject($select);
        $resultSet   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
    }

}