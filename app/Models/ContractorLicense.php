<?php

namespace App\Models;

use CodeIgniter\Model;

class ContractorLicense extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'contractor_licenses';
	protected $primaryKey           = 'contractor_license_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['contractor_license_id', 'contractor_id','contractor_license_category_id','contractor_license_start_date',
        'contractor_license_end_date','license_amount'];

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

    public function getContractorLicenseByContractorId($id){
        $builder = $this->db->table('contractor_licenses as cl');
        $builder->join('contractor_license_categories as clc','cl.contractor_license_category_id = clc.contractor_license_category_id' );
        $builder->where('cl.contractor_id = '.$id);
        return $builder->get()->getResultObject();
    }
}
