<?php
namespace Calender\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Sql, Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Expression;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;

class EventsTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
        return $resultSet;
	}
	public function showEventsFromUser($id)
	{
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new Sql($adapter);
        $select = $sql->select();
        $statement = "SELECT DISTINCT `e`.*, `guest`.`ev_id` AS `ev_id`, `guest`.`user_id` AS `user_id` 
        FROM `events` AS `e` 
        LEFT JOIN `guest` 
        ON `e`.`id` = `guest`.`ev_id` 
        AND `guest`.`user_id` = " .$id." 
        WHERE `e`.`userid` 
        LIKE " .$id."
        OR `guest`.`user_id` 
        LIKE " .$id."
        ";
        $resultSet   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
	}
    public function searchId($id)
    {
	    $zoekterm = $id;
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new Sql($adapter);
        $select = $sql->select();
        $select->from('events')
        ->where->like('id', $zoekterm);
        $statement = $sql->getSqlStringForSqlObject($select);
        $resultSet   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
    }
    public function saveEvent(Events $events, $userid)
    {
        $data = array(
        	'title'  => $events->title,
            'start' => $events->start,
            'end' => $events->end,
            'userid' => $userid,
            );
        $id = (int)$events->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getEvent($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Event id does not exist');
            }
        }
    }
    public function alterEvent(Events $events)
    {
        $data = array(
        'start' => $events->start,
        'end' => $events->end,
        'roomkey' => $events->roomkey,
        'roomid' => $events->roomid,
        );
        $id = (int)$events->id;
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new Sql($adapter);
        $update = $sql->update();
        $update->table('events');
        $update->set($data);
        $update->where(array('id' => $id));
        $statement = $sql->getSqlStringForSqlObject($update);
        $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);

    }
    public function getEvent($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    public function deleteEvent($eventId, $roomid)
    {
        $data = array(
            'id' => $eventId,
            'roomid' => $roomid
        );
        $this->tableGateway->delete($data);
    }

    public function getOwner($eventid)
    {
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new Sql($adapter);
        $statement = 'select username, email from user as u left join events as e on u.user_id = e.userid where e.id = 208;';
        $result = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);
        return $result;
        
    }

}