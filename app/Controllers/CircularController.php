<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CircularController extends PostController
{
	public function circulars() {
		$data['firstTime'] = $this->session->firstTime;
		$data['username'] = $this->session->user_username;
		$circulars = array();
		$posts = $this->post
			->where('p_type', 2)
			->where('p_status', 2)
			->join('users', 'posts.p_signed_by = users.user_id')
			->orderBy('posts.p_date', 'DESC')
			->paginate('9');
		$l_user = $this->user->where('user_username', $this->session->user_username)
			->join('employees', 'users.user_employee_id = employees.employee_id')
			->first();

		$department_id = $l_user['employee_department_id'];
		$i = 0;
		foreach ($posts as $post):
			$posts_dpts = json_decode($post['p_recipients_id']);
			$recipients = [];
			foreach($posts_dpts as $posts_dpt):
				array_push($recipients, $this->department->find($posts_dpt));
			endforeach;
			if(in_array($department_id, $posts_dpts)):
				$user = $this->user->find($post['p_by']);
				$post['created_by'] = $user['user_name'];
				$post['recipients'] = $recipients;
				$circulars[$i] = $post;
				$i++;
			endif;
		endforeach;

//		$i = 0;
//		$new_circulars = array();
//		foreach ($circulars as $circular):
//			$user = $this->user->where('user_id', $circular['p_by'])->first();
//			$circular['created_by'] = $user['user_name'];
//			$new_circulars[$i] = $circular;
//			$i++;
//		endforeach;
		$data['pager'] = $this->post->pager;
		$data['circulars'] = $circulars;
		return view('/pages/posts/circulars/circulars', $data);
	}

	public function new_circular() {
		if($this->request->getMethod() == 'get'):
			$data['firstTime'] = $this->session->firstTime;
			$data['username'] = $this->session->user_username;

			return view('/pages/posts/circulars/new-circular', $data);

		endif;
	}

	public function internal_circular(){
		if($this->request->getMethod() == 'get'):
			$data['signed_by'] = $this->user->where('user_status', 1)
				->groupStart()
				->where('user_type', 2)
				->orWhere('user_type', 3)
				->groupEnd()
				->findAll();
			$data['departments']= $this->department->findAll();
			$data['pager'] = $this->post->pager;
			$data['firstTime'] = $this->session->firstTime;
			$data['username'] = $this->session->user_username;
			return view('/pages/posts/circulars/new-internal-circular', $data);
		endif;

		if($this->request->getMethod() == 'post'):
			$p_attachments = array();
			if(isset($_POST['p_attachment'])):
				$p_attachments = $_POST['p_attachment'];
				unset($_POST['p_attachment']);
			endif;
			$_POST['p_by'] = $this->session->user_id;
			$_POST['p_direction'] = 1;
			$_POST['p_status'] = 0;
			$_POST['p_type'] = 2;
			if(isset($_POST['all_department'])):
				unset($_POST['all_department']);
				$departments = $this->department->findAll();
				$new_dpt = array();
				$i = 0;
				foreach ($departments as $department):
					$new_dpt[$i] = $department['dpt_id'];

					$i++;
				endforeach;

				$_POST['p_recipients_id'] = json_encode($new_dpt);
			else:
				$_POST['p_recipients_id'] = json_encode($_POST['p_recipients_id']);

			endif;
			$p_id = $this->post->insert($_POST);

			if ($p_id):

				if(count($p_attachments) > 0):
					foreach ($p_attachments as $attachment):
						$attachment_array = array(
							'pa_post_id'=> $p_id,
							'pa_link' => $attachment
						);
						$this->pa->save($attachment_array);
					endforeach;
				endif;
				$response['success'] = true;
				$response['message'] = 'Successfully created Circular';
			else:
				$response['success'] = false;
				$response['message'] = 'There was an error while creating Circular ';
			endif;
			return $this->response->setJSON($response);

		endif;
	}

	public function view_circular($p_id){
		$data['firstTime'] = $this->session->firstTime;
		$data['username'] = $this->session->user_username;
		$attachments = array();
		$post = $this->post->where('p_id', $p_id)
			->join('users', 'posts.p_signed_by = users.user_id')
			->first();

		$user = $this->user->where('user_id', $post['p_by'])->first();
		$post['created_by'] = $user['user_name'];
		$_attachments = $this->pa->where('pa_post_id', $p_id)->findAll();
		if(!empty($_attachments)):
			$attachments = $_attachments;
		endif;

		$dpts = json_decode($post['p_recipients_id']);
		$departments = array();
		$i = 0;
		foreach ($dpts as $dpt):
			$_dpt = $this->department->where('dpt_id', $dpt)->first();
			$departments[$i] = $_dpt['dpt_name'];
			$i++;
		endforeach;

		$data['departments'] = $departments;
		$data['post'] = $post;
		$data['attachments'] = $attachments;
		$data['organization'] = $this->organization->first();



		return view('/pages/posts/circulars/view-circular', $data);
	}

	public function external_circular(){

		$data['signed_by'] = $this->user->where('user_status', 1)
			->groupStart()
			->where('user_type', 2)
			->orWhere('user_type', 3)
			->groupEnd()
			->findAll();
		$data['departments']= $this->department->findAll();
		$data['pager'] = $this->post->pager;
		$data['firstTime'] = $this->session->firstTime;
		$data['username'] = $this->session->user_username;
		return view('/pages/posts/circulars/new-external-circular', $data);
	}

	public function my_circulars(){
		$data['firstTime'] = $this->session->firstTime;
		$data['username'] = $this->session->user_username;
		$l_user = $this->user->where('user_username', $this->session->user_username)
			->join('employees', 'users.user_employee_id = employees.employee_id')
			->first();
		$circulars = $this->post->where('p_type', 2)
			->where('p_by', $l_user['user_id'])
			->join('users', 'posts.p_signed_by = users.user_id')
			->paginate('9');
		$new_circulars = array();
		$i = 0;
		foreach ($circulars as $circular):
			$user = $this->user->where('user_id', $circular['p_by'])->first();
			$circular['created_by'] = $user['user_name'];
			$new_circulars[$i] = $circular;
			$i++;
		endforeach;
		$data['pager_cir'] = $this->post->pager;
		$data['circulars'] = $new_circulars;


		$circulars = $this->post->where('p_type', 2)
			->where('p_signed_by', $l_user['user_id'])
			->join('users', 'posts.p_signed_by = users.user_id')
			->paginate('9');
		$new_circulars = array();
		$i = 0;
		foreach ($circulars as $circular):
			$user = $this->user->where('user_id', $circular['p_by'])->first();
			$circular['created_by'] = $user['user_name'];
			$new_circulars[$i] = $circular;
			$i++;
		endforeach;
		$data['pager_scir'] = $this->post->pager;
		$data['s_circulars'] = $new_circulars;

		return view('/pages/posts/circulars/my-circulars', $data);
	}

}