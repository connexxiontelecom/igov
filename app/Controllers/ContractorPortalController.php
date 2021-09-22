<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Contract;
use App\Models\ContractAttachment;
use App\Models\ContractBidding;
use App\Models\ContractBiddingDocument;

class ContractorPortalController extends BaseController
{

    public function __construct()
    {
        $this->contract = new Contract();
        $this->contractattachment = new ContractAttachment();
        $this->contractbidding = new ContractBidding();
        $this->contractbiddingdocument = new ContractBiddingDocument();

        helper(['url', 'form', 'Contractor_helper']);
    }

    public function dashboard()
	{
	    $contractor_id = $this->session->contractor_id;
        $contractor_bids = $this->contractbidding->getContractorBidsByContractorById($contractor_id);
	    $data = [
	      'contractor_name'=>$this->session->contractor_name,
          'contractor_email'=>$this->session->contractor_email,
          'contractor_address'=>$this->session->contractor_address,
          'contractor_mobile_no'=>$this->session->contractor_mobile_no,
          'my_bids'=>$contractor_bids,
          'pending'=>$this->contractbidding->getPendingBidsByContractorId($contractor_id),
          'approved'=>$this->contractbidding->getApprovedBidsByContractorId($contractor_id),
          'declined'=>$this->contractbidding->getDeclinedBidsByContractorId($contractor_id),
        ];
	    return view('pages/procurement/auth/dashboard', $data);
	}

	public function contractListing(){
        $data = [
            'contracts'=>$this->contract->getAllContracts(),
        ];
        return view('pages/procurement/auth/contract-listing',$data);
    }

    public function viewContractDetails($slug){
        $contract = $this->contract->getContractBySlug($slug);
        if(!empty($contract)){
            $contractor_id = $this->session->contractor_id;
            $contract_id = $contract['contract_id'];
            $bidding = $this->contractbidding->getContractByContractorIdAndContractId($contractor_id, $contract_id);
            $data = [
              'contract'=>$contract,
              'bidding'=>$bidding,
              'bid_documents'=>$this->contractbiddingdocument->getContractBidDocumentByContractBidId($bidding['contract_bidding_id'] ?? 0),
              'attachments'=>$this->contractattachment->getAllContractAttachmentsByContractId($contract['contract_id'])
            ];
            return view('pages/procurement/auth/view-contract',$data);
        }else{
            return redirect()->back()->with("error", "<strong>Whoops!</strong>No record found.");
        }
    }

    public function showContractBiddingView($slug){

        $contract = $this->contract->getContractBySlug($slug);
        if(!empty($contract)){
            $data = [
                'contract'=>$contract
            ];
            return view('pages/procurement/auth/contract-bidding',$data);
        }else{
            return redirect()->back()->with("error", "<strong>Whoops!</strong>No record found.");
        }
    }

    public function submitBid(){
        $contract_id = $this->request->getVar('contract');
        //return print_r($_POST);
        if(!empty($contract_id)){
            $contract = $this->contract->getContractById($contract_id);
            $validation = $this->validate([
                'title.*'=>'required',
                'document'=>'uploaded[document]',
                'comment.*'=>'required'
            ],[
                'title.*'=>['required'=>'Enter title for each field.'],
                'document'=>['uploaded'=>'Choose a document to upload'],
                'comment.*'=>['required'=>'Leave a comment']
            ]);
            if(!$validation){
                $data = [
                    'validation'=>$this->validator,
                    'contract'=>$contract
                ];
                return view('pages/procurement/auth/contract-bidding', $data);
            }else{
                $contractor = $this->session->contractor_id;
                $bid_data = [
                    'contract_bd_contractor_id'=>$contractor,
                    'contract_bd_contract_id'=>$contract_id
                ];
                $bid_id = $this->contractbidding->insert($bid_data);
                #Publish documents
                $files = $this->request->getFileMultiple('document');
                $file_counter = count($files);
                //return print_r($this->request->getVar('title')[$file_counter-1]);
                foreach($files as $file){
                    if($file->isValid() && !$file->hasMoved() ){
                        $filename = $file->getRandomName();
                        $file->move('uploads/posts', $filename);
                        $bid_doc_data = [
                            'contract_bidding_bid_id' => $bid_id,
                            'contract_bidding_title' => $this->request->getVar('title')[$file_counter-1],
                            'contract_bidding_document' => $filename,
                            'contract_bidding_comment' => $this->request->getVar('comment')[$file_counter-1],
                        ];
                        $this->contractbiddingdocument->save($bid_doc_data);
                        $file_counter--;
                    }
                }
                return redirect()->route('contract-listing')->with('success', 'Your bid was submitted successfully.');
                /*for($i = 0; $i<$file_counter; $i++){
                    #process document
                    if ($this->request->getFile('document')[$i]->isValid()){
                        //$extension = $attachment->guessExtension();
                        $filename = $this->request->getFile('document')[$i]->getRandomName();
                        $this->request->getFile('document')[$i]->move('uploads/posts', $filename);
                        $bid_doc_data = [
                            'contract_bidding_bid_id' => $bid_id,
                            'contract_bidding_title' => $this->request->getVar('title')[$i],
                            'contract_bidding_document' => $filename,
                            'contract_bidding_comment' => $this->request->getVar('comment')[$i],
                        ];
                        $this->contractbiddingdocument->save($bid_doc_data);
                        return redirect()->route('contract-listing')->with('success', 'Your bid was submitted successfully.');
                    }else{
                        return redirect()->back()->with("error", "<strong>Whoops!</strong>Something went wrong.");
                    }

                }*/
            }
        }else{
            return redirect()->back()->with("error", "<strong>Whoops!</strong>No record found.");
        }

    }
}
