<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Contract;
use App\Models\ContractCategory;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\UserModel;

class ContractController extends BaseController
{
    public function __construct()
    {
        if (session()->get('type') == 1): //employee
            echo view('auth/access_denied');
            exit;
        endif;
        $this->contractcategory = new ContractCategory();
        $this->employee = new Employee();
        $this->department = new Department();
        $this->user = new UserModel();
        $this->position = new Position();
        $this->contract = new Contract();


    }
	public function showContractCategories()
	{
        $data = [
            'firstTime'=>$this->session->firstTime,
            'username'=>$this->session->username,
            //'contractors'=>$this->contractor->getAllContractors()
        ];
        return view('pages/procurement/contract-categories',$data);
	}

	public function saaaveContractCategory(){
        //'contract_cat_name','contract_cat_description

    }
    public function saveContractCategory(){
        $inputs = $this->validate([
            'category_name' => ['rules'=> 'required', 'label'=>'Category name','errors' => [
                'required' => 'Enter category name']]
        ]);
        if (!$inputs) {
            return view('pages/procurement/contract-categories', [
                'validation' => $this->validator,
                'firstTime'=>$this->session->firstTime,
                'username'=>$this->session->username,
            ]);
        }else{
            $data = [
                'contract_cat_name'=>$this->request->getPost('category_name'),
                'contract_cat_description'=>$this->request->getPost('description')
            ];

            $this->contractcategory->save($data);
            return redirect()->back()->with("success", "<strong>Success!</strong> New contractor added");
        }
    }

    public function showContractForm(){
        $data = [
            'firstTime'=>$this->session->firstTime,
            'username'=>$this->session->username,
            'department_employees'=>$this->_get_department_employees(),
            'employees'=>$this->employee->getAllEmployee()
        ];
        return view('pages/procurement/add-new-contract',$data);
    }

    public function setNewContract(){
        $inputs = $this->validate([
            'title' => ['rules'=> 'required', 'label'=>'Title','errors' => [
                'required' => 'Enter title']],
            'tender_board' => ['rules'=> 'required', 'label'=>'Member','errors' => [
                'required' => 'Select board members']],
            'opening_date' => ['rules'=> 'required', 'label'=>'Opening date','errors' => [
                'required' => 'Enter opening date']],
            'closing_date' => ['rules'=> 'required', 'label'=>'Closing date','errors' => [
                'required' => 'Enter closing date']],
            'scope' => ['rules'=> 'required', 'label'=>'Scope','errors' => [
                'required' => 'What is the scope of work to be done?']],
            'eligibility' => ['rules'=> 'required', 'label'=>'Eligibility','errors' => [
                'required' => 'Enter eligibility']],
            /*'certificate' => ['rules'=> 'required', 'label'=>'Certificate','errors' => [
                'required' => 'Upload certificate of No Objection.']],
        'tender_documents' => ['rules'=> 'required', 'label'=>'Tender document','errors' => [
            'required' => 'Upload tender documents']]*/
        ]);
        if (!$inputs) {
            return view('pages/procurement/add-new-contract', [
                'validation' => $this->validator,
                'firstTime'=>$this->session->firstTime,
                'username'=>$this->session->username,
                'employees'=>$this->employee->getAllEmployee()
            ]);
        }else{
            $data = [
                'contract_title'=>$this->request->getPost('title'),
                'contract_scope'=>$this->request->getPost('scope'),
                'contract_eligibility'=>$this->request->getPost('eligibility'),
                'contract_certificate'=>$this->request->getPost('certificate'),
                'contract_opening_date'=>$this->request->getPost('opening_date'),
                'contract_closing_date'=>$this->request->getPost('closing_date'),
                'contract_slug'=>substr(sha1(time()),23,40)
            ];

            $contract_id = $this->contract->insert($data);
            #Board members
                /*foreach($this->request->getPost('members') as $member){
                    $m_data = [
                      ''
                    ];
                }*/
            #Contract attachments

            return redirect()->back()->with("success", "<strong>Success!</strong> New contract added. Though it is yet to be published.");
        }
    }

    public function allContracts(){
        return view('pages/procurement/all-contracts', [
            'firstTime'=>$this->session->firstTime,
            'username'=>$this->session->username,
        ]);
    }

    private function _get_department_employees() {
        $department_employees = [];
        $departments = $this->department->findAll();
        foreach ($departments as $department) {
            $department_employees[$department['dpt_name']] = [];
            $employees = $this->employee
                ->where('employee_department_id', $department['dpt_id'])
                ->findAll();
            foreach ($employees as $employee) {
                $user = $this->user->where('user_employee_id', $employee['employee_id'])->first();
                if ($user['user_status'] == 1 && ($user['user_type'] == 3 || $user['user_type'] == 2)) {
                    $employee['user'] = $user;
                    $employee['position'] = $this->position->find($employee['employee_position_id']);
                    array_push($department_employees[$department['dpt_name']], $employee);
                }
            }
        }
        return $department_employees;
    }

}
