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

class GuestTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

    public function searchInvites($id)
    {
        $zoekterm = $id;
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new Sql($adapter);
        $select = $sql->select();
        $select->from(array('e' => 'guest'));
        $select->join(array('u' => 'user'),     // join table with alias
            'e.user_id = u.user_id'); 
        $select->where('ev_id='. $zoekterm);
        $statement = $sql->getSqlStringForSqlObject($select);
        $resultSet   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
    }
    public function saveGuests($Guest, $eventId)
    {
        $data = array(
            'ev_id' => $eventId,
            'user_id' => $Guest,
            );
        $this->tableGateway->insert($data);
    }
     public function deleteGuest($userid, $eventId)
    {
        $data = array(
            'ev_id' => $eventId,
            'user_id' => $userid,
        );
        $this->tableGateway->delete($data);
    }
    public function alterGuest($eventid, $userid, $attendingstatus)
    {
        $data = array(
            'ev_id' => $eventid,
            'user_id' => $userid,
            'attending' => $attendingstatus,
        );
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new Sql($adapter);
        $update = $sql->update();
        $update->table('guest');
        $update->set($data);
        $update->where(array('user_id' => $userid, 'ev_id' => $eventid));
        $statement = $sql->getSqlStringForSqlObject($update);
        $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);
    }
    public function getGuestStatus($eventid, $userid)
    {
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new Sql($adapter);
        $select = $sql->select();
        $select->from('guest');
        $select->where(array('user_id' => $userid, 'ev_id' => $eventid));
        $statement = $sql->getSqlStringForSqlObject($select);
        $status = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);
        return $status;
    }
        public function getGuestList($eventid)
    {
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new Sql($adapter);
        $select = $sql->select();
        $select->from('guest');
         $select->join(array('u' => 'user'),     // join table with alias
            'guest.user_id = u.user_id'); 
        $select->where(array('ev_id' => $eventid, 'attending' => 'true'));
        $statement = $sql->getSqlStringForSqlObject($select);
        $list = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);
        return $list;
    }

}