<?php
namespace Social\Model;

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
use Zend\Paginator\Paginator;

class MemberTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($paginated=false)
    {

        if($paginated) {
            // create a new Select object for the table album
                        $select = new Select();
                        $select->from(array('m' => 'member'));
            $select->join(array('u' => 'user'),     // join table with alias
                'm.u_id = u.user_id');  
            // create a new result set based on the Album entity
            $resultSetPrototype = new ResultSet();
            //$resultSetPrototype->setArrayObjectPrototype(new Member());
            // create a new pagination adapter object
            $paginatorAdapter = new \Zend\Paginator\Adapter\DbSelect(
            // our configured select object
                $select,
            // the adapter to run it against
                $this->tableGateway->getAdapter(),
            // the result set to hydrate
                $resultSetPrototype
                );
            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }
        $resultSet = $this->tableGateway->select();
return $resultSet;
}
public function fetchAllFriends($paginated=false, $userid)
{
    if($paginated) {
        $select = new Select();
        $select->from(array('f' => 'friend'));
        $select->join(array('u' => 'user'),     // join table with alias
            'f.friend_id = u.user_id'); 
        $select->where('f.fuser_id =' . $userid);
        // create a new result set based on the Album entity
        $resultSetPrototype = new ResultSet();
        //$resultSetPrototype->setArrayObjectPrototype(new Member());
        // create a new pagination adapter object
        $paginatorAdapter = new \Zend\Paginator\Adapter\DbSelect(
        // our configured select object
            $select,
        // the adapter to run it against
            $this->tableGateway->getAdapter(),
        // the result set to hydrate
            $resultSetPrototype
            );
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
}
$resultSet = $this->tableGateway->select();
return $resultSet;
}
public function fetchAllFriendsProfile($paginated=false, $userid)
{
    if($paginated) {
        $select = new Select();
        $select->from(array('f' => 'friend'));
        $select->join(array('u' => 'user'),     // join table with alias
            'f.fuser_id = u.user_id'); 
        $select->where('f.friend_id =' . $userid);
        // create a new result set based on the Album entity
        $resultSetPrototype = new ResultSet();
        //$resultSetPrototype->setArrayObjectPrototype(new Member());
        // create a new pagination adapter object
        $paginatorAdapter = new \Zend\Paginator\Adapter\DbSelect(
        // our configured select object
            $select,
        // the adapter to run it against
            $this->tableGateway->getAdapter(),
        // the result set to hydrate
            $resultSetPrototype
            );
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
}
$resultSet = $this->tableGateway->select();
return $resultSet;
    
}
public function fetchMyself($paginated=false, $userid)
{
    $adapter = $this->tableGateway->getAdapter();
    $sql     = new Sql($adapter);
    $select = $sql->select();
    $select->from('user')
    ->where->like('user_id', $userid);
    $statement = $sql->getSqlStringForSqlObject($select);
    $resultSet   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);
    return $resultSet;
}
public function setInviteFriend($insertId, $userid)
{
    $newData = array(
        'invite_requestor_id' => $userid,
        'invite_requested_id' => $insertId
        );
    $adapter = $this->tableGateway->getAdapter();
    $sql     = new Sql($adapter);
    $insert = $sql->insert('friend_invite');
    $insert->values($newData);
    $selectString = $sql->getSqlStringForSqlObject($insert);
    $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
}
public function areWeFriends($myid, $otherid)
{
    $adapter = $this->tableGateway->getAdapter();
    $sql     = new Sql($adapter);
    $select = $sql->select();
    $select->from(array('f' => 'friend'));
    $select->columns(array('fid' => new \Zend\Db\Sql\Expression('COUNT(*)')));
    $where = new Where();
    $where->equalTo('f.fuser_id', $myid)
        ->AND
        ->equalTo('f.friend_id', $otherid)
        ->OR
        ->equalTo('f.fuser_id', $otherid)
        ->AND
        ->equalTo('f.friend_id', $myid)
    ;
    $select->where($where);
    $statement = $sql->getSqlStringForSqlObject($select);
    $resultSet   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE); 
    return $resultSet;
}
public function countMyFriends($myid)
{
    $adapter = $this->tableGateway->getAdapter();
    $sql     = new Sql($adapter);
    $select = $sql->select();
    $select->from(array('f' => 'friend'));
    $select->columns(array('fid' => new \Zend\Db\Sql\Expression('COUNT(*)')));
    $where = new Where();
    $where->equalTo('f.fuser_id', $myid)
        ->OR
        ->equalTo('f.friend_id', $myid)
    ;
    $select->where($where);
    $statement = $sql->getSqlStringForSqlObject($select);
    $resultSet   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE); 
    return $resultSet;
}
public function getInviteFriend($paginated=false, $userid)
{
    if($paginated) {
        $select = new Select();
        $select->from(array('f' => 'friend_invite'));
    $select->join(array('u' => 'user'),     // join table with alias
        'f.invite_requestor_id = u.user_id'); 
    $select->where('f.invite_requested_id =' . $userid);
    $resultSetPrototype = new ResultSet();
    //$resultSetPrototype->setArrayObjectPrototype(new Member());
    // create a new pagination adapter object
    $paginatorAdapter = new \Zend\Paginator\Adapter\DbSelect(
    // our configured select object
        $select,
    // the adapter to run it against
        $this->tableGateway->getAdapter(),
    // the result set to hydrate
        $resultSetPrototype
        );
    $paginator = new Paginator($paginatorAdapter);
    return $paginator;
    }
    $resultSet = $this->tableGateway->select();
    return $resultSet;
}
public function agreeInvite($inviteId)
{
    $adapter = $this->tableGateway->getAdapter();
    $sql     = new Sql($adapter);
    $select = $sql->select();
    $select->from(array('f' => 'friend_invite'));
    $select->where('f.invite_id =' . $inviteId);
    $statement = $sql->getSqlStringForSqlObject($select);
    $resultSet   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);
    return $resultSet;
                        //$resultSet : 
                        //$resultSet->invite_id 39  
                        //$resultSet->invite_requestor_id 2  
                        //$resultSet->invite_requested_id 1
}
public function deleteInvite($inviteId)
{
    $adapter = $this->tableGateway->getAdapter();
    $sql     = new Sql($adapter);
    $delete = $sql->delete();
    $delete->from('friend_invite');
    $delete->where('invite_id =' . $inviteId);
    $statement = $sql->getSqlStringForSqlObject($delete);
    $resultSet = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);
}

public function deleteFriend($fid)
{
    $adapter = $this->tableGateway->getAdapter();
    $sql     = new Sql($adapter);
    $delete = $sql->delete();
    $delete->from('friend');
    $delete->where('fid =' . $fid);
    $statement = $sql->getSqlStringForSqlObject($delete);
    $resultSet = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);
}

public function insertFriend($invite_requestor_id, $invite_requested_id)
{
    $newData = array(
        'friend_id' => $invite_requestor_id,
        'fuser_id' => $invite_requested_id
        );
    $adapter = $this->tableGateway->getAdapter();
    $sql     = new Sql($adapter);
    $insert = $sql->insert('friend');
    $insert->values($newData);
    $selectString = $sql->getSqlStringForSqlObject($insert);
    $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
}



public function getMember($id)
{
    $id  = (int) $id;
    $rowset = $this->tableGateway->select(array('id' => $id));
    $row = $rowset->current();
    if (!$row) {
        throw new \Exception("Could not find row $id");
    }
    return $row;
}

public function saveMember(Member $member)
{
    $data = array(
        'group_id' => $member->group_id,
        'group_role' => $member->group_role,
        'user_id'  => $member->user_id,
        );

    $id = (int)$member->group_id;
    if ($id == 0) {
        $this->tableGateway->insert($data);
    } else {
        if ($this->getMember($id)) {
            $this->tableGateway->update($data, array('id' => $id));
        } else {
            throw new \Exception(' id does not exist');
        }
    }
}

public function deleteMember($id)
{
    $this->tableGateway->delete(array('id' => $id));
}

public function filter($term, $table, $row){
    $zoekterm = '%' . $term . '%';
    $adapter = $this->tableGateway->getAdapter();
    $sql     = new Sql($adapter);
    $select = $sql->select();
    $select->from($table)
    ->join('user', 'member.u_id = user.user_id')
    ->where->like($row, $zoekterm);
    $statement = $sql->getSqlStringForSqlObject($select);
    $resultSet   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);
    return $resultSet;

} 
public function getUserId(Array $term){
    
    if (count($term) == 0) {
    //    return array();
        return array();
    }
    $adapter = $this->tableGateway->getAdapter();
    $sql     = new Sql($adapter);
    $select = $sql->select();
    $select->from('user');
    $select->where->in('user_id', $term);
    $statement = $sql->getSqlStringForSqlObject($select);
    $resultSet   = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);
    return $resultSet;

} 
}