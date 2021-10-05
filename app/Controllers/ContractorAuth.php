<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Contractor;

class ContractorAuth extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'Contractor_helper']);
        $this->contractor = new Contractor();
    }

    public function login()
    {
        $data = [];

        if ($this->request->getMethod() == 'post') {
            $validation = $this->validate([
                'email' => 'required|valid_email',
                'password' => 'required'
            ], [
                'email' => ['required' => 'Enter your registered email to access your contractor account.', 'valid_email' => 'Enter a valid email address'],
                'password' => ['required' => 'Enter your registered password']
            ]);
            if (!$validation) {
                $data = [
                    'validation' => $this->validator
                ];
                return view('pages/procurement/auth/login', $data);
            } else {
                $email = $this->request->getVar('email');
                $password = $this->request->getVar('password');
                $contractor = $this->contractor->where('contractor_email', $email)->first();
                if (!empty($contractor)) {
                    $check = password_verify($password, $contractor['password']);
                    if ($check) {
                        $user_session = [
                          'contractor_name'=>$contractor['contractor_name'],
                          'contractor_email'=>$contractor['contractor_email'],
                          'contractor_id'=>$contractor['contractor_id'],
                          'contractor_address'=>$contractor['contractor_address'],
                          'contractor_mobile_no'=>$contractor['contractor_mobile_no'],
                            'isLoggedIn' => true,
                        ];
                        $this->session->set($user_session);
                        return redirect()->route('contractor-dashboard');
                    } else {
                        return redirect()->back()->with("error", "<strong>Whoops!</strong> Invalid login credentials. Check and try again.");
                    }
                } else {
                    return redirect()->back()->with("error", "<strong>Whoops!</strong> Record does not exist.");
                }
            }
        }
        if ($this->request->getMethod() == 'get') {
            $data['url'] = '';
            $data['errors'] = '';
            return view('pages/procurement/auth/login', $data);

        }
    }


    public function register()
	{
		if($this->request->getMethod() == 'post'){
		    $validate = $this->validate([
		        'contractor_name'=>'required',
                'contractor_email'=>'required|valid_email|is_unique[contractors.contractor_email]',
                'password'=>'required|min_length[5]|max_length[16]',
                'confirm_password'=>'required|min_length[5]|max_length[16]|matches[password]',
                'contractor_address'=>'required',
                'contractor_mobile_no'=>'required|min_length[10]'
            ],[
                'contractor_name'=>['required'=>'Enter contractor name'],
                'contractor_email'=>['required'=>'Enter a valid email address', 'valid_email'=>'Enter a valid email address',
                    'is_unique'=>'That email is already taken. Try a different one.'],
                'password'=>['required'=>'Choose a password','min_length'=>'Weak password length. Min. length: 5', 'max_length'=>'Number of characters exceeds required length of 16 characters'],
                'confirm_password'=>['required'=>'Re-type password', 'matches'=>'Password mis-match. Try again.'],
                'contractor_address'=>['required'=>'Enter contractor office address'],
                'contractor_mobile_no'=>['required'=>'Enter contractor mobile no.']
            ]);
		    if(!$validate){
		        $data = [
		          'validation'=>$this->validator
                ];
		        return view('pages/procurement/auth/register', $data);
            }else{

            }
        }

		if($this->request->getMethod() == 'get'){

        }
	}
}
