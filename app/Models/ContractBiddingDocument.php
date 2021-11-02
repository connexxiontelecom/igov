<?php

namespace App\Models;

use CodeIgniter\Model;

class ContractBiddingDocument extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'contract_bidding_documents';
	protected $primaryKey           = 'contract_bidding_doc_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['contract_bidding_doc_id','contract_bidding_bid_id','contract_bidding_title',
        'contract_bidding_document','contract_bidding_comment'];



    // Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];


    public function getContractBidDocumentByContractBidId($contract_bid_id){
        return ContractBiddingDocument::where('contract_bidding_bid_id', $contract_bid_id)->findAll();
    }
}
