<?php
namespace Calender\Model;

// Add these import statements
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Events
{
    public $id;
    public $start;
    public $end;
    public $title;
    public $userid;                      

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id']))     ? $data['id']     : null;
        $this->start = (isset($data['start'])) ? $data['start'] : null;
        $this->end = (isset($data['end'])) ? $data['end'] : null;
        $this->title  = (isset($data['title']))  ? $data['title']  : null;
        $this->userid  = (isset($data['userid']))  ? $data['userid']  : null;

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