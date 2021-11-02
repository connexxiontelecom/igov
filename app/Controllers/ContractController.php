<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Contract;
use App\Models\ContractAttachment;
use App\Models\ContractBoard;
use App\Models\ContractCategory;
use App\Models\ContractConversation;
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
        $this->contractattachment = new ContractAttachment();
        $this->contractboard = new ContractBoard();
        $this->contractcoversation = new ContractConversation();


    }
	public function showContractCategories()
	{
        $data = [
            'firstTime'=>$this->session->firstTime,
            'username'=>$this->session->username,
            'contractcategories'=>$this->contractcategory->getContractCategories()
        ];
        return view('pages/procurement/contract-categories',$data);
	}

	public function storeContractCategory(){
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
    public function updateContractCategory(){
        $inputs = $this->validate([
            'category_name' => ['rules'=> 'required', 'label'=>'Category name','errors' => [
                'required' => 'Enter category name']],
            'catid'=>['rules'=>'required']
        ]);
        if (!$inputs) {
            return view('pages/procurement/contract-categories', [
                'validation' => $this->validator,
                'firstTime'=>$this->session->firstTime,
                'username'=>$this->session->username,
            ]);
        }else{
            $catid = $this->request->getVar('catid');
            $data = [
                'contract_cat_name'=>$this->request->getPost('category_name'),
                'contract_cat_description'=>$this->request->getPost('description')
            ];

            $this->contractcategory->update($catid,$data);
            return redirect()->back()->with("success", "<strong>Success!</strong> Your changes were saved");
        }
    }

    public function showContractForm(){
        $data = [
            'firstTime'=>$this->session->firstTime,
            'username'=>$this->session->username,
            'department_employees'=>$this->_get_department_employees(),
            'employees'=>$this->employee->getAllEmployee(),
            'contract_categories'=>$this->contractcategory->getContractCategories(),
            'tender'=>0
        ];
        return view('pages/procurement/add-new-contract',$data);
    }

    public function setNewContract(){
        helper(['form','url']);
        $validation = $this->validate([
            'title'=>'required',
            'scope'=>'required',
            'eligibility'=>'required',
            'opening_date'=>'required',
            'closing_date'=>'required',
            'certificate'=>'uploaded[certificate]',
            'tender_documents.*'=>'uploaded[tender_documents]',
            'tender_board'=>'required',
            'contract_category'=>'required'
        ],[
            'title'=>['required'=>'Enter contract title'],
            'scope'=>['required'=>"What's the scope of this contract? Enter it here"],
            'eligibility'=>['required'=>"What's the criteria for this contract?"],
            'opening_date'=>['required'=>"When will this contract be open for application? Choose a date"],
            'closing_date'=>['required'=>"When will this contract be considered as close for application? Choose a date"],
            'certificate'=>['uploaded'=>"Upload certificate of No Objection."],
            'tender_board'=>['required'=>'Select board members for this contract'],
            'contract_category'=>['required'=>'Select contract category']
        ]);
        if($attachments = $this->request->getFiles())
        {
            foreach($attachments['tender_documents'] as $attach)
            {
                if ($attach->isValid() && ! $attach->hasMoved()) {

                }else{
                    return view('pages/procurement/add-new-contract', [
                        'validation' => $this->validator,
                        'firstTime'=>$this->session->firstTime,
                        'username'=>$this->session->username,
                        'employees'=>$this->employee->getAllEmployee(),
                        'contract_categories'=>$this->contractcategory->getContractCategories(),
                        'tender'=>1
                    ]);
                }
            }
        }
        if(!$validation){
            return view('pages/procurement/add-new-contract', [
                'validation' => $this->validator,
                'firstTime'=>$this->session->firstTime,
                'username'=>$this->session->username,
                'employees'=>$this->employee->getAllEmployee(),
                'tender'=>0
            ]);
        }else{
            $filename = '';
            if($this->request->getFile('certificate')) {
                $certificate = $this->request->getFile('certificate');
                if ($certificate->isValid()) {
                    $extension = $certificate->guessExtension();
                    $filename = $certificate->getRandomName(); // uniqid() . time() . '.' . $extension;
                    $certificate->move('uploads/posts', $filename);
                }
            }
            $data = [
               'contract_title'=>$this->request->getPost('title'),
               'contract_scope'=>$this->request->getPost('scope'),
               'contract_eligibility'=>$this->request->getPost('eligibility'),
               'contract_certificate'=>$filename,
               'contract_opening_date'=>$this->request->getPost('opening_date'),
               'contract_closing_date'=>$this->request->getPost('closing_date'),
               'contract_slug'=>substr(sha1(time()),23,40),
                'contract_category_id'=>$this->request->getPost('contract_category')
            ];
            $contract_id = $this->contract->insert($data);
            #Contract attachment
            if($this->request->getFileMultiple('tender_documents')){
                foreach ($this->request->getFileMultiple('tender_documents') as $attachmen){
                    if($attachmen->isValid() ){
                        //$extension = $attachmen->guessExtension();
                        $filename = $attachmen->getRandomName();
                        $attachmen->move('uploads/posts', $filename);
                        $contract_attachment = [
                            'contract_att_contract_id' => $contract_id,
                            'contract_att_attachment' => $filename
                        ];
                        $this->contractattachment->save($contract_attachment);
                    }
                }
            }

            #Board members
            foreach ($this->request->getVar('tender_board') as $board){
                $board_data = [
                  'contract_b_contract_id'=>$contract_id,
                    'contract_b_employee_id'=>$board
                ];
                $this->contractboard->save($board_data);
            }
            return redirect()->back()->with("success", "<strong>Success!</strong> New contract added. Though it is yet to be published.");
        }
        /*
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
            'certificate' => ['rules'=> 'required', 'label'=>'Certificate','errors' => [
                'required' => 'Upload certificate of No Objection.']],
        /*'tender_documents' => ['rules'=> 'required', 'label'=>'Tender document','errors' => [
            'required' => 'Upload tender documents']]
        ]);*/
        /*if (!$inputs) {
            return view('pages/procurement/add-new-contract', [
                'validation' => $this->validator,
                'firstTime'=>$this->session->firstTime,
                'username'=>$this->session->username,
                'employees'=>$this->employee->getAllEmployee()
            ]);
        }else{*/
            /*$data = [
                'contract_title'=>$this->request->getPost('title'),
                'contract_scope'=>$this->request->getPost('scope'),
                'contract_eligibility'=>$this->request->getPost('eligibility'),
                'contract_certificate'=>$this->request->getPost('certificate'),
                'contract_opening_date'=>$this->request->getPost('opening_date'),
                'contract_closing_date'=>$this->request->getPost('closing_date'),
                'contract_slug'=>substr(sha1(time()),23,40)
            ];*/

            //$contract_id = $this->contract->insert($data);
            #Board members
                /*foreach($this->request->getPost('members') as $member){
                    $m_data = [
                      ''
                    ];
                }*/
            #Contract attachments

            //return redirect()->back()->with("success", "<strong>Success!</strong> New contract added. Though it is yet to be published.");
        //}
    }

    public function allContracts(){
        return view('pages/procurement/all-contracts', [
            'firstTime'=>$this->session->firstTime,
            'username'=>$this->session->username,
            'contracts'=>$this->contract->getAllContracts()
        ]);
    }

    public function viewContract($slug){
        $contract = $this->contract->getContractBySlug($slug);
        if(!empty($contract)){
            $data = [
              'contract'=>$contract,
                'firstTime'=>$this->session->firstTime,
                'username'=>$this->session->username,
                'attachments'=>$this->contractattachment->getAllContractAttachmentsByContractId($contract['contract_id']),
                'participants'=>$this->contractboard->getContractBoardMembersByContractId($contract['contract_id']),
                'conversations'=>$this->contractcoversation->getContractConversationByContractId($contract['contract_id'])
            ];
            return view('pages/procurement/view-contract', $data);
        }else{
            return redirect()->back()->with("error", "<strong>Whoops!</strong> No record found.");
        }
    }

    public function showEditContractForm($slug){
        $contract = $this->contract->getContractBySlug($slug);
        if(!empty($contract)){
            $data = [
                'firstTime'=>$this->session->firstTime,
                'username'=>$this->session->username,
                'department_employees'=>$this->_get_department_employees(),
                'employees'=>$this->employee->getAllEmployee(),
                'contract_categories'=>$this->contractcategory->getContractCategories(),
                'contract'=>$contract,
                'tender'=>0
            ];
            return view('pages/procurement/edit-contract',$data);
        }else{
            return redirect()->back();
        }

    }
    public function publishContract(){
        helper(['form', 'url']);
        $validate = $this->validate([
            'contract_id'=>'required'
        ]);
        $contract = $this->contract->getContractById($this->request->getVar('contract_id'));
        if(!empty($contract)){
            $data = [
              'contract_published_by'=>$this->session->user_employee_id,
              'contract_published_date'=>date('Y-m-d'),
              'contract_status'=>1
            ];
            $this->contract->update($this->request->getVar('contract_id'), $data);
            return redirect()->to(site_url('view-contract')."/".$this->request->getPost('contract_slug'));
        }else{
            //return redirect()->back()->with("error", "<strong>Whoops!</strong> No record found.");
            return redirect()->to(site_url('view-contract')."/".$this->request->getPost('contract_slug'));
        }
    }

    public function setNewConversation(){
        $inputs = $this->validate([
            'comment' => ['rules'=> 'required', 'label'=>'Comment','errors' => [
                'required' => 'Leave a comment']]
        ]);
        if (!$inputs) {
            return redirect()->back()->with("error", "<strong>Whoops!</strong> ");
        }else{
            $slug = $this->request->getPost('contract_cm_slug');
            $data = [
                'contract_convo_employee_id'=>$this->session->user_employee_id,
                'contract_convo'=>$this->request->getPost('comment'),
                'contract_convo_contract_id'=>$this->request->getPost('contract_cm_id')
            ];
            $this->contractcoversation->save($data);
            return redirect()->to(site_url('view-contract')."/".$slug);

        }
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
