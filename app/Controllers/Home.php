<?php

namespace App\Controllers;

use App\Models\Department;
use App\Models\Notification;
use App\Models\Organization;
use App\Models\Position;
use App\Models\Post;
use App\Models\UserModel;
use App\Models\Employee;

class Home extends BaseController
{
  private $organization;
  private $notification;
  private $user;
  private $employee;
  private $post;
  private $position;
  private $department;

	public function __construct()
	{
		if (session()->get('type') == 1):
			echo view('auth/access_denied');
			exit;
		endif;
		$this->organization = new Organization();
		$this->notification = new Notification();
    $this->user = new UserModel();
    $this->employee = new Employee();
    $this->post = new Post();
    $this->position = new Position();
    $this->department = new Department();
  }

	public function index()
	{
		$data['username'] = $this->session->user_username;
		$data['firstTime'] = $this->session->firstTime;
		$data['organization'] = $this->organization->first();
		$data['notifications'] = [];
		$data['overview_stats']['memos'] = $this->_count_memos();
		$data['overview_stats']['circulars'] = $this->_count_circulars();
		$data['overview_stats']['notices'] = $this->_count_notices();
		$data['overview_stats']['my_memos'] = $this->_count_my_memos();
		$data['overview_stats']['my_circulars'] = $this->_count_my_circulars();
		$data['overview_stats']['my_notices'] = $this->_count_my_notices();
		$data['overview_stats']['unsigned_memos'] = $this->_count_unsigned_memos();
		$data['overview_stats']['unsigned_circulars'] = $this->_count_unsigned_circulars();
		$data['overview_stats']['unsigned_notices'] = $this->_count_unsigned_notices();
		return view('pages/dashboard/index', $data);
	}

	private function _get_notifications() {
		return $this->notification->where('target_id', $this->session->user_id)->findAll();
	}

	private function _count_memos() {
    $user_id = session()->get('user_id');
    $user_data = $this->user->where('user_id', $user_id)->first();
    $employee_id = $user_data['user_employee_id'];
    $employee_data = $this->employee->where('employee_id', $employee_id)->first();
    $position_id = $employee_data['employee_position_id'];
    $memos = $this->post
      ->where('p_status', 2)
      ->where('p_type', 1)
      ->orderBy('p_date', 'DESC')
      ->findAll();
    $new_memos = [];
    foreach ($memos as $memo) {
      $recipient_ids = json_decode($memo['p_recipients_id']);
      $recipients = [];
      if ($recipient_ids) {
        foreach ($recipient_ids as $recipient_id) {
          array_push($recipients, $this->position->find($recipient_id));
        }
        if (in_array($position_id, $recipient_ids) || $memo['p_signed_by'] == session()->user_id || $memo['p_by'] == session()->user_id) {
          $memo['written_by'] = $this->user->find($memo['p_by']);
          $memo['signed_by'] = $this->user->find($memo['p_signed_by']);
          $memo['recipients'] = $recipients;
          array_push($new_memos, $memo);
        }
      }
    }
    return count($new_memos);
  }

  private function _count_my_memos() {
    $memos = $this->post
      ->where('p_by', $this->session->user_id)
      ->where('p_type', 1)
      ->orderBy('p_date', 'DESC')
      ->findAll();
    foreach ($memos as $key => $memo) {
      $memos[$key]['signed_by'] = $this->user->find($memo['p_signed_by']);
    }
    return count($memos);
  }

  private function _count_unsigned_memos() {
    $memos = $this->post
      ->where('p_signed_by', $this->session->user_id)
      ->where('p_type', 1)
      ->where('p_status', 0)
      ->orderBy('p_date', 'DESC')
      ->findAll();
    foreach ($memos as $key => $memo) {
      $recipient_ids = json_decode($memo['p_recipients_id']);
      $recipients = [];
      if ($recipient_ids) {
        foreach ($recipient_ids as $recipient_id) {
          array_push($recipients, $this->position->find($recipient_id));
        }
      } else {
        $external_recipients = explode("\n", $memo['p_recipients_id']);
        $memos[$key]['external_recipients'] = $external_recipients;
      }
      $memos[$key]['written_by'] = $this->user->find($memo['p_by']);
      $memos[$key]['recipients'] = $recipients;
    }
    return count($memos);
  }

  private function _count_circulars() {
    $l_user = $this->user->where('user_username', $this->session->user_username)
      ->join('employees', 'users.user_employee_id = employees.employee_id')
      ->first();
    $department_id = $l_user['employee_department_id'];
    $circulars = array();
    $posts = $this->post
      ->where('p_type', 2)
      ->where('p_status', 2)
      ->join('users', 'posts.p_signed_by = users.user_id')
      ->orderBy('posts.p_date', 'DESC')
      ->findAll();
    $i = 0;
    foreach ($posts as $post):
      $posts_dpts = json_decode($post['p_recipients_id']);
      $recipients = [];
      foreach($posts_dpts as $posts_dpt):
        array_push($recipients, $this->department->find($posts_dpt));
      endforeach;
      if(in_array($department_id, $posts_dpts) || $post['p_by'] == session()->user_id || $post['p_signed_by'] == session()->user_id):
        $user = $this->user->find($post['p_by']);
        $post['created_by'] = $user['user_name'];
        $post['recipients'] = $recipients;
        $circulars[$i] = $post;
        $i++;
      endif;
    endforeach;
    return count($circulars);
  }

  private function _count_my_circulars() {
    $circulars = $this->post
      ->where('p_by', $this->session->user_id)
      ->where('p_type', 2)
      ->orderBy('p_date', 'DESC')
      ->findAll();
    foreach ($circulars as $key => $circular) {
      $circulars[$key]['signed_by'] = $this->user->find($circular['p_signed_by']);
    }
    return count($circulars);
  }

  private function _count_unsigned_circulars() {
    $circulars = $this->post
      ->where('p_signed_by', $this->session->user_id)
      ->where('p_type', 2)
      ->where('p_status', 0)
      ->orderBy('p_date', 'DESC')
      ->findAll();
    foreach ($circulars as $key => $circular) {
      $recipient_ids = json_decode($circular['p_recipients_id']);
      $recipients = [];
      if ($recipient_ids) {
        foreach ($recipient_ids as $recipient_id) {
          array_push($recipients, $this->department->find($recipient_id));
        }
      } else {
        $external_recipients = explode("\n", $circular['p_recipients_id']);
        $circulars[$key]['external_recipients'] = $external_recipients;
      }

      $created_by = $this->user->find($circular['p_by']);
      $circulars[$key]['created_by'] = $created_by['user_name'];
      $circulars[$key]['recipients'] = $recipients;
    }
    return count($circulars);
  }

  private function _count_notices() {
    $notices = $this->post
      ->where('p_status', 2)
      ->where('p_type', 3)
      ->orderBy('p_date', 'DESC')
      ->findAll();
    foreach($notices as $key => $notice) {
      $written_by = $this->user->find($notice['p_by']);
      $signed_by = $this->user->find($notice['p_signed_by']);
      $notices[$key]['written_by'] = $written_by;
      $notices[$key]['signed_by'] = $signed_by;
    }
    return count($notices);
  }

  private function _count_my_notices() {
    $notices = $this->post
      ->where('p_by', $this->session->user_id)
      ->where('p_type', 3)
      ->orderBy('p_date', 'DESC')
      ->findAll();
    foreach($notices as $key => $notice) {
      $signed_by = $this->user->find($notice['p_signed_by']);
      $notices[$key]['signed_by'] = $signed_by;
    }
    return count($notices);
  }

  private function _count_unsigned_notices() {
    $notices = $this->post
      ->where('p_signed_by', $this->session->user_id)
      ->where('p_type', 3)
      ->where('p_status', 0)
      ->orderBy('p_date', 'DESC')
      ->findAll();
    foreach($notices as $key => $notice) {
      $written_by = $this->user->find($notice['p_by']);
      $signed_by = $this->user->find($notice['p_signed_by']);
      $notices[$key]['written_by'] = $written_by;
      $notices[$key]['signed_by'] = $signed_by;
    }
    return count($notices);
  }
}
