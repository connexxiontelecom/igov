<?php

namespace App\Models;

use CodeIgniter\Model;

class ContractConversation extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'contract_conversations';
	protected $primaryKey           = 'contract_conversation_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['contract_convo_id','contract_convo_contract_id','contract_convo_employee_id','contract_convo'];



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

   public function getContractConversationByContractId($id){
        $builder = $this->db->table('contract_conversations as cc');
        $builder->join('employees as e','e.employee_id = cc.contract_convo_employee_id' );
        $builder->where('cc.contract_convo_contract_id = '.$id);
        return $builder->get()->getResultObject();
    }
   /* public function getContractConversationByContractId($id){
        $builder = $this->db->table('contract_boards as cb');
        $builder->join('employees as e','e.employee_id = cb.contract_b_employee_id' );
        $builder->where('cb.contract_b_contract_id = '.$id);
        return $builder->get()->getResultObject();
    }*/
}
