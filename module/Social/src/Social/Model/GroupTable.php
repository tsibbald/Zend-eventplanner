<?php
namespace Social\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Sql,
Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Expression;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GroupTable
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


    public function getGroup($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveGroup(Group $group)
    {
        $data = array(
            'group_id' => $group->group_id,
            'group_name'  => $group->group_name,
            );

        $id = (int)$group->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getGroup($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Group id does not exist');
            }
        }
    }

    public function deleteGroup($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }

    public function filter($term){
        $zoekterm = '%' . $term . '%';
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new Sql($adapter);
        $select = $sql->select();
        $select->from('group')
        ->where->like('group_name', $zoekterm);
        $statement = $sql->getSqlStringForSqlObject($select);
        $resultSet   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
        
    }
}