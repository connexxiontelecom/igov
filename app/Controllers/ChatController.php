<?php

namespace App\Controllers;

use Ably\AblyRest;
use App\Controllers\BaseController;
use App\Models\Chat;
use App\Models\Employee;

class ChatController extends BaseController
{
    public function __construct()
    {
        if (session()->get('type') == 1): //employee
            echo view('auth/access_denied');
            exit;
        endif;
        $this->chat = new Chat();
        $this->employee = new Employee();

    }
	public function chat()
	{
	    $data = [
	      'firstTime'=>$this->session->firstTime,
          'username'=>$this->session->username,
          'employees'=>$this->employee->getAllEmployeeExceptAuthUser($this->session->user_employee_id),
          'emp'=>  $this->employee->getEmployeeByUserEmployeeId($this->session->user_employee_id)
        ];
	    return view('pages/chat/chat', $data);
	}

	public function getMessages(){
        $selected_user = $this->request->getVar('user');
        $auth_user = $this->session->user_employee_id;
        $selected_employee = $this->employee->getEmployeeByUserEmployeeId($selected_user);
        $auth_employee = $this->employee->getEmployeeByUserEmployeeId($auth_user);
            $messages = $this->chat->fetchChatMessages($auth_user, $selected_user);
            //$messages = $this->chat->getMessagesWithUserByUserId($from_user_id, $to_user_id);
            $data = [
                'messages'=>$messages,
                'auth_employee'=>$auth_employee,
                'selected_employee'=>$selected_employee
            ];
            $html = "";
            $html2 = "";
            foreach ($messages as $m){
                /*if($m['chat_from_id'] == $auth_employee['employee_id']){
                     $html .="<li class='clearfix odd'>";
                        $html .="<div class='chat-avatar'>";
                            $html .="<img src='/assets/images/users/user-5.jpg' class='rounded' alt='James Z'>";
                        $html .='</div>';
                        $html .="<div class='conversation-text'>";
                            $html .="<div class='ctext-wrap'>";
                                $html .="<i>".$auth_employee['employee_f_name']." ".$auth_employee['employee_l_name']."</i>";
                                $html .="<p>".$m['chat_message']."</p>";
                                $html .="<p>".date('F j, Y g:i a', strtotime($m['created_at']))."</p>";
                            $html .='</div>';
                        $html .='</div>';
                    $html .='</li>';
                    echo $html;
                }*/

                if($m['chat_from_id'] == $selected_employee['employee_id']){
                    $html2 .="<li class='clearfix'>";
                    $html2 .="<div class='chat-avatar'>";
                    $html2 .="<img src='/assets/images/users/user-5.jpg' class='rounded' alt='James Z'>";
                    $html2 .='</div>';
                    $html2 .="<div class='conversation-text'>";
                    $html2 .="<div class='ctext-wrap'>";
                    $html2 .="<i>".$selected_employee['employee_f_name']." ".$selected_employee['employee_l_name']."</i>";
                    $html2 .="<p>".$m['chat_message']."</p>";
                    $html2 .="<p>".date('F j, Y g:i a', strtotime($m['created_at']))."</p>";
                    $html2 .='</div>';
                    $html2 .='</div>';
                    $html2 .='</li>';
                    echo $html2;
                }
            }
            //return json_encode($messages);
            //return view('pages/chat/partials/_messages',$data);

    }

    public function sendMessage(){
        $message = $this->request->getVar('message');
        $user = $this->request->getVar('user');
        $auth_user = $this->session->user_employee_id;
        if(!empty($message) && !empty($user)){
            $data = [
                'chat_to_id'=>$user,
                'chat_from_id'=>$auth_user,
                'chat_message'=>$message
            ];
            $this->chat->save($data);
            $selected_employee = $this->employee->getEmployeeByUserEmployeeId($user);
            $auth_employee = $this->employee->getEmployeeByUserEmployeeId($auth_user);
            $messages = $this->chat->fetchChatMessages($auth_user, $user);
            //$messages = $this->chat->getMessagesWithUserByUserId($from_user, $user);
            $data = [
                'messages'=>$messages,
                'auth_employee'=>$auth_employee,
                'selected_employee'=>$selected_employee
            ];
            $ably = new AblyRest('aht0IA.nknxWw:BjDaL6hWD5Pc929a');
            $channel = $ably->channel('chatchannel');
            $channel->publish('helloevent', $message);
            return view('pages/chat/partials/_messages',$data);
        }
    }
}
