<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Contract;
use App\Models\ContractBidding;
use App\Models\ContractBiddingDocument;
use App\Models\ContractCategory;
use App\Models\Contractor;
use App\Models\ContractorAttachment;
use App\Models\ContractorLicense;
use App\Models\ContractorLicenseCategory;
use App\Models\Employee;
use App\Models\Project;
use App\Models\UserModel;

class ContractorController extends BaseController
{
    public function __construct()
    {
        if (session()->get('type') == 1): //employee
            echo view('auth/access_denied');
            exit;
        endif;
        $this->user = new UserModel();
        $this->employee = new Employee();
        $this->contractor = new Contractor();
        $this->contractorlicensecategory = new ContractorLicenseCategory();
        $this->contractorlicense = new ContractorLicense();
        $this->contractbidding = new ContractBidding();
        $this->contractbiddingdocument = new ContractBiddingDocument();
        $this->contract = new Contract();
        $this->project = new Project();
        $this->contractcategory = new ContractCategory();
        $this->contractorattachment = new ContractorAttachment();

    }
	public function manageContractors()
	{
        $data = [
            'firstTime'=>$this->session->firstTime,
            'username'=>$this->session->username,
            'contractors'=>$this->contractor->getAllContractors()
        ];
        return view('pages/project/contractors',$data);
	}

	public function showNewContractorForm(){
        $data = [
            'firstTime'=>$this->session->firstTime,
            'username'=>$this->session->username,
            'licenses'=>$this->contractorlicensecategory->getAllContractorLicenseCategory(),
        ];
        return view('pages/project/add-new-contractor', $data);
    }
    public function addNewContractor(){
        $inputs = $this->validate([
            'contractor_name' => ['rules'=> 'required', 'label'=>'Contractor Name','errors' => [
                'required' => 'Enter contractor name']],
            'email' => ['rules'=> 'required', 'errors'=>['required'=>'Enter valid email address']],
            'mobile_no' => ['rules'=> 'required', 'errors'=>['required'=>'Enter a functional mobile number']],
            'address' => ['rules'=> 'required', 'errors'=>['required'=>'Enter contractor office address']],
            'contractor_license' => ['rules'=> 'required', 'errors'=>['required'=>'Select contractor license']],
        ]);
        if (!$inputs) {
            return view('pages/project/add-new-contractor', [
                'validation' => $this->validator,
                'firstTime'=>$this->session->firstTime,
                'username'=>$this->session->username,
                'licenses'=>$this->contractorlicensecategory->getAllContractorLicenseCategory(),
            ]);
        }else{
            $data = [
              'contractor_name'=>$this->request->getPost('contractor_name'),
              'contractor_email'=>$this->request->getPost('email'),
              'contractor_mobile_no'=>$this->request->getPost('mobile_no'),
              'contractor_website'=>$this->request->getPost('website'),
              'about_contractor'=>$this->request->getPost('about_contractor'),
              'contractor_address'=>$this->request->getPost('address'),
              'contractor_added_by'=>$this->session->user_employee_id,
                'contractor_license_id'=>$this->request->getPost('contractor_license'),
                'contractor_license_category_id'=>$this->request->getPost('contractor_license'),
            ];
            $contractor_id = $this->contractor->insert($data);
            #Contractor attachment
            if($this->request->getFileMultiple('attachments')){
                foreach ($this->request->getFileMultiple('attachments') as $attachmen){
                    if($attachmen->isValid() ){
                        $filename = $attachmen->getRandomName();
                        $attachmen->move('uploads/posts', $filename);
                        $contractor_attachment = [
                            'contractor_attach_contractor_id' => $contractor_id,
                            'contractor_attachment' => $filename
                        ];
                        $this->contractorattachment->save($contractor_attachment);
                    }
                }
            }
            return redirect()->back()->with("success", "<strong>Success!</strong> New contractor added");
        }
    }

    public function contractorDetail($id){
        $contractor = $this->contractor->getContractorById($id);
        if(!empty($contractor)){
            $data = [
              'contractor'=>$contractor,
              'firstTime'=>$this->session->firstTime,
              'username'=>$this->session->username,
              'categories'=>$this->contractorlicensecategory->getAllContractorLicenseCategory(),
              'licenses'=>$this->contractorlicense->getContractorLicenseByContractorId($id),
                'documents'=>$this->contractorattachment->getContractorAttachmentsByContractorId($id)
            ];
            return view('pages/procurement/contractor-detail', $data);
        }else{
            return redirect()->back()->with("error", "<strong>Whoops!</strong> No record found.");
        }
    }

    public function renewLicense(){
        $inputs = $this->validate([
            'license_category' => ['rules'=> 'required', 'label'=>'Category','errors' => [
                'required' => 'Select category']],
            'start_date' => ['rules'=> 'required', 'errors'=>['required'=>'Enter start date']],
            'end_date' => ['rules'=> 'required', 'errors'=>['required'=>'Enter end date']],
            'amount' => ['rules'=>'required', 'errors'=>['Enter amount']]
        ]);
        if (!$inputs) {
            return redirect()->back()->with("error", "Something went wrong.");
            /*return view('pages/project/add-new-contractor', [
                'validation' => $this->validator,
                'firstTime'=>$this->session->firstTime,
                'username'=>$this->session->username,
            ]);*/
        }else{
            $data = [
                'contractor_id'=>$this->request->getPost('contractorId'),
                //'contractor_email'=>$this->request->getPost('description'),
                'license_amount'=>$this->request->getPost('amount'),
                'contractor_license_end_date'=>$this->request->getPost('end_date'),
                'contractor_license_start_date'=>$this->request->getPost('start_date'),
                'contractor_license_category_id'=>$this->request->getPost('license_category')
            ];

            $this->contractorlicense->save($data);
            return redirect()->back()->with("success", "<strong>Success!</strong> New contractor license renewed.");
        }
    }
    public function updateContractorStatus(){
        $inputs = $this->validate([
            'reason' => ['rules'=> 'required', 'label'=>'Reason','errors' => [
                'required' => 'State your reason']],
            'contractorId' => ['rules'=> 'required', 'errors'=>['required'=>'Enter start date']],
            'status' => ['rules'=> 'required', 'errors'=>['required'=>'Select status']],
        ]);
        if (!$inputs) {
            return redirect()->back()->with("error", "Something went wrong.");
            /*return view('pages/project/add-new-contractor', [
                'validation' => $this->validator,
                'firstTime'=>$this->session->firstTime,
                'username'=>$this->session->username,
            ]);*/
        }else{
            $data = [
                'contractor_status'=>$this->request->getPost('status'),
                'contractor_black_list_comment'=>$this->request->getPost('reason'),
            ];

            $this->contractor->update($this->request->getPost('contractorId'),$data);
            return redirect()->back()->with("success", "<strong>Success!</strong> Your changes were updated.");
        }
    }


    public function manageBids(){
        $data = [
            'bids'=>$this->contractbidding->getAllContractorBids(),
            'firstTime'=>$this->session->firstTime,
            'username'=>$this->session->username
        ];
        return view('pages/procurement/manage-bids', $data);
    }

    public function viewBid($id){
        $bid = $this->contractbidding->getContractorBidByBidId($id);

        if(!empty($bid)){
            $documents = $this->contractbiddingdocument->getContractBidDocumentByContractBidId($id);
            $data = [
                'bid'=>$bid,
                'firstTime'=>$this->session->firstTime,
                'username'=>$this->session->username,
                'documents'=>$documents
            ];
            return view('pages/procurement/view-bid', $data);
        }else{
            return redirect()->back()->with("error", "<strong>Whoops!</strong> No record found.");
        }

    }

    public function updateBidStatus(){
        if ($this->request->getMethod() == 'post') {
            $validation = $this->validate([
                'contract_bid_id' => 'required',
                'status' => 'required'
            ], [
                'status' => ['required' => 'Select status']
            ]);
            if (!$validation) {
                $data = [
                    'validation' => $this->validator
                ];
                return redirect()->back()->with("error", "<strong>Whoops!</strong> Something went wrong.");
            }else{
                $bid = $this->contractbidding->getBidById($this->request->getVar('contract_bid_id'));
                if(!empty($bid)){
                    $bid_data = [
                      'contract_bd_status'=>$this->request->getVar('status'),
                      'contract_bd_updated_by'=>$this->session->employee_id,
                      'contract_bd_date_updated'=>date('Y-m-d'),
                    ];
                    $this->contractbidding->update($this->request->getVar('contract_bid_id'), $bid_data);
                    #Convert contract to project
                    if($this->request->getVar('status') == 1){ //approve
                        $contract_bid = $this->contractbidding->getBidById($this->request->getVar('contract_bid_id'));
                        if(!empty($contract_bid)){
                            $contract = $this->contract->getContractById($contract_bid['contract_bd_contract_id']);
                            if(!empty($contract)){
                                $project_data = [
                                    'project_manager_id'=>$this->session->user_employee_id,
                                    'project_name'=>$contract['contract_title'],
                                    'project_sponsor'=>'N/A',
                                    'project_description'=>$contract['contract_scope'],
                                    'project_priority'=>1
                                ];
                                $this->project->save($project_data);
                                return redirect()->back()->with("success", "<strong>Success!</strong> Your changes were saved.");
                            }
                        }
                    }
                }else{
                    return redirect()->back()->with("error", "<strong>Whoops!</strong> No record found.");
                }
            }
        }

    }
}
