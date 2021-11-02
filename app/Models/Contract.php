<?php

namespace App\Models;

use CodeIgniter\Model;

class Contract extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'contracts';
	protected $primaryKey           = 'contract_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['contract_title','contract_scope','contract_eligibility','contract_published_by',
        'contract_published_date','contract_certificate','contract_opening_date','contract_closing_date','contract_status',
        'contract_slug', 'contract_category_id'];



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


	public function getAllContracts(){
	    return Contract::orderBy('contract_id', 'DESC')->findAll();
    }

    public function getContractBySlug($slug){
	    return Contract::where('contract_slug', $slug)->first();
    }

    public function getContractById($id){
       /* $builder = $this->db->table('contracts as c');
        $builder->where('c.contract_id = '.$id);
        return $builder->get()->getFirstRow();*/
        return Contract::where('contract_id', $id)->first();
    }
}
