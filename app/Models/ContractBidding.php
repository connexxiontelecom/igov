<?php

namespace App\Models;

use CodeIgniter\Model;

class ContractBidding extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'contract_biddings';
	protected $primaryKey           = 'contract_bidding_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['contract_bd_contractor_id','contract_bd_contract_id','contract_bd_status',
        'contract_bd_updated_by','contract_bd_date_updated'];



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

	public function getContractByContractorIdAndContractId($contractor_id, $contract_id){
	    return ContractBidding::where('contract_bd_contractor_id', $contractor_id)
            ->where('contract_bd_contract_id', $contract_id)->first();
    }

    /*public function getContractorBidsByContractorById($id){
	    return ContractBidding::where('contract_bd_contractor_id', $id)
            ->orderBy('contract_bidding_id', 'DESC')->findAll();
    }*/

    public function getContractorBidsByContractorById($id){
        $builder = $this->db->table('contracts as c');
        $builder->join('contract_biddings as cb','c.contract_id = cb.contract_bd_contract_id' );
        $builder->where('cb.contract_bd_contractor_id = '.$id);
        $builder->orderBy('cb.contract_bidding_id', 'DESC');
        $builder->limit(5);
        return $builder->get()->getResultArray();
    }

    public function getPendingBidsByContractorId($id){
        return ContractBidding::where('contract_bd_contractor_id', $id)->where('contract_bd_status',0)->findAll();
    }
    public function getApprovedBidsByContractorId($id){
        return ContractBidding::where('contract_bd_contractor_id', $id)->where('contract_bd_status',1)->findAll();
    }
    public function getDeclinedBidsByContractorId($id){
        return ContractBidding::where('contract_bd_contractor_id', $id)->where('contract_bd_status',2)->findAll();
    }
}
