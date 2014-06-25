<?php
namespace Social\Model;

class Member 
{
	public $group_id;
	public $group_role;                       
	public $user_id;

	public function exchangeArray($data)
	{
		$this->group_id     = (isset($data['group_id']))     ? $data['group_id']     : null;
		$this->group_role  = (isset($data['group_role']))  ? $data['group_role']  : null;
		$this->user_id  = (isset($data['user_id']))  ? $data['user_id']  : null;
	}
}