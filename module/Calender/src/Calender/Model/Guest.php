<?php
namespace Calender\Model;

// Add these import statements
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Guest
{
    public $id;
    public $ev_id;
    public $user_id;
                      // <-- Add this variable

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
        $this->ev_id = (isset($data['ev_id'])) ? $data['ev_id'] : null;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;

    }
    
     public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

   
}