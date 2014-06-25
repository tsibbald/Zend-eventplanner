<?php
namespace Calender\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Calender\Model\Events;          // <-- Add this import
use Zend\View\Model\JsonModel;
use Calender\Model\Guest;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Zend\Mail\Message;
use Zend\Mail;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
define('DATE_ICAL', 'Ymd\THis\Z');

class CalenderController extends AbstractActionController 
{
    const ROUTE_CHANGEPASSWD = 'zfcuser/changepassword';
    const ROUTE_LOGIN        = 'zfcuser/login';
    const ROUTE_REGISTER     = 'zfcuser/register';
    const ROUTE_CHANGEEMAIL  = 'zfcuser/changeemail';
    const CONTROLLER_NAME    = 'zfcuser';
	protected $CalenderTable;
    protected $MemberTable;
    protected $GuestTable;
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
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute(static::ROUTE_LOGIN);
        }
       
        $userid = $this->zfcUserAuthentication()->getIdentity()->getId();
        return new ViewModel(array(
         'userid' => $userid,
        ));
    }
    public function eventsAction()
    {
        $eventz = Array();
        $userid = $this->zfcUserAuthentication()->getIdentity()->getId();
        $events = $this->getEventsTable()->showEventsFromUser($userid);
        foreach ($events as $event) {
                $start_split_date_time = explode(" ", $event->start);
                $end_split_date_time = explode(" ", $event->end);
                $arr['title'] = $event->title;
                $arr['start'] =  $start_split_date_time[0] .'T' . $start_split_date_time[1];
                $arr['end'] = $end_split_date_time[0] .'T' . $end_split_date_time[1];
                $arr['id'] = $event->id;
                if($event->userid == $userid)
                {
                    $arr['editable'] = true;
                    $arr['color'] = '#5eb2d9';

                }
                else
                {
                    $arr['editable'] = false;
                    $arr['color'] = '#ff5d5e';
                }
                $eventz[] = $arr;
        }
        $viewModel = new JsonModel($eventz);
        return $viewModel;
    }
    public function getGuestTable()
    {
        if(!$this->GuestTable) {
            $sm = $this->getServiceLocator();
            $this->GuestTable = $sm->get('Calender\Model\GuestTable');
        }
        return $this->GuestTable;
    }
    public function getEventsTable()
    { 
        if (!$this->CalenderTable) {
            $sm = $this->getServiceLocator();
            $this->CalenderTable = $sm->get('Calender\Model\EventsTable');
        }
        return $this->CalenderTable;
    }

    public function getMemberTable()
    {
        if (!$this->MemberTable) {
            $sm = $this->getServiceLocator();
            $this->MemberTable = $sm->get('Social\Model\MemberTable');
        }
        return $this->MemberTable;
    }

    public function evdetailAction()
    {
        $userid = $this->zfcUserAuthentication()->getIdentity()->getId();

        $eventId = (int) $this->params()->fromRoute('id', 0);
        $GuestTable = $this->getGuestTable()->searchInvites($eventId);
        $eventdetail = $this->getEventsTable()->searchId($eventId);
        //var_dump($eventdetail);
        // $this->layout('layout/eventdetail-layout.phtml');
        $owner = $this->getEventsTable()->getOwner($eventId);
        $paginator = $this->getMemberTable()->fetchAll(true);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage(10);

        //Guestlist
        $guestlist = $this->getGuestTable()->getGuestList($eventId);


        return new ViewModel(array(
            'paginator' => $paginator,
            'data' => $eventdetail, 
            'eventinvites' => $GuestTable, 
            'myuserid' => $userid, 
            'guestlist' => $guestlist,
            'owner' => $owner
            ));
    }

    public function emailAction()
    {
        $request = $this->getRequest();
        $post = $request->getPost();
        // loop that gets the text from the array and splits it using the comma to get the emailadrress, then uses the address to send the invite mail.
        foreach ($post as $key) {
            for ($i=0; $i < count($key); $i++) 
            {     
                $a = $key[$i];
                $b = $a['email'];
                $c = explode(",", $b);
                $eventid = $a['eventid'];
                $start = $a['start'];
                $end = $a['end'];
                $title = $a['title'];
                $this->sendInviteMail($c[1],$eventide,$starte,$ende,$titlee,$c[0]);
            }
        }   
    }

    public function sendInviteMail($email,$eventide,$starte,$ende,$titlee,$name,$owner)
    { 
        $view = new ViewModel(array(
           'fullname' => $name,
           'start' => $start,
           'end' => $end,
           'title' => $title,
           'eventid' => 'http://booking/calender/evdetail/' . $eventide,
           ));
        $view->setTerminal(true);
        $view->setTemplate('Application/view/emails/email_ical');
        $this->mailerZF2()->send(array(
            'to' => $email,
            'subject' => 'You are invited to an event',
            'fullname' => 'Tim Sibbald',
            'start' => $start,
            'end' => $end,
            'title' => $title,
            'link' => $link,
            'owner' => $owner,
            ), $view,$start);
    }

    //inject guests
    public function injectAction()
    {
                // List with users from the userlist in the eventdetail
        $request = $this->getRequest();
        $post = $request->getPost();
        
        // Get eventid from url
        $eventId = (int) $this->params()->fromRoute('id', 0);
        
        // Put userid's from post in array
        $userid = array(); // array with userid's
        foreach ($post as $key) {
            for ($i=0; $i < count($key); $i++) { 
                $userid[] = $key[$i]['id'];
               // $this->getGuestTable()->saveGuests($userid, $eventId);
            }
        }
        // echo 'posted users';
        // print_r($userid);
        
        // List with excisting users from the guest table
        $GuestTable = $this->getGuestTable()->searchInvites($eventId);
        $Excisting_guests = array();
         foreach ($GuestTable as $key) {
           $Excisting_guests[] = $key->user_id;
        }
        // echo 'excisting users';
        // print_r($Excisting_guests);

        // Difference between new posted usersid's and excisting guests/ 
        $result = array_diff($userid , $Excisting_guests);
        
        // Array with results from query [select * from user where user_id IN (1,2,3,4)]
        $excisting_users = $this->getMemberTable()->getUserId($result);

        // print_r($result);
        foreach ($excisting_users as $key) {
            $this->getGuestTable()->saveGuests($key->user_id, $eventId);

        }
       
        $result = array_diff($result , $excisting_users);
        echo $result;
       
      
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        $post = $request->getPost();
        $eventId = (int) $this->params()->fromRoute('id', 0);
        foreach ($post as $key) {
            for ($i=0; $i < count($key); $i++) 
            {     
                $a = $key[$i];
                $userid = $a['id'];
                $this->getGuestTable()->deleteGuest($userid, $eventId);
            }
        }   
    }
    public function deleventAction()
    {
        $request = $this->getRequest();
        $post = $request->getPost();
        $eventId = (int) $this->params()->fromRoute('id', 0);
        $eventdetails = $this->getEventsTable()->getEvent($eventId);
        $roomkey    =   $eventdetails->roomkey;
        $roomid     =   $eventdetails->roomid;
        $this->getEventsTable()->deleteEvent($eventId, $roomid);
        return true;
    }

    public function addAction()
    {   
        $userid = $this->zfcUserAuthentication()->getIdentity()->getId();
        $request = $this->getRequest();
        $event = new Events();
        $event->exchangeArray($request->getPost());
        $this->getEventsTable()->saveEvent($event, $userid);
    }

    public function changeAction()
    {
        // Drag and drop event
        $request = $this->getRequest();
        $eventdata = $request->getPost();
        $eventdetails = $this->getEventsTable()->getEvent($eventdata['id']);
        $event = new Events();
        $event->exchangeArray($eventdata);
        $this->getEventsTable()->alterEvent($event);
        
    }

     public function attendingAction()
    {
        $userid = $this->zfcUserAuthentication()->getIdentity()->getId();
        $eventId = (int) $this->params()->fromRoute('id', 0);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost('attendingstatus');
            // set attending status of guest
            $this->getGuestTable()->alterGuest($eventId, $userid, $post);
        }
        // Return attending status to guestpage
        $userstatus = $this->getGuestTable()->getGuestStatus($eventId, $userid);
        
        $viewModel = new JsonModel($userstatus);
        
        return $viewModel;

    }
}