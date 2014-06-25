<?php
namespace Social\Model;


class Group 
{
    public $group_id;
    public $group_name;                       

    public function exchangeArray($data)
    {
        $this->group_id     = (isset($data['group_id']))     ? $data['group_id']     : null;
        $this->group_name  = (isset($data['group_name']))  ? $data['group_name']  : null;

    }
}