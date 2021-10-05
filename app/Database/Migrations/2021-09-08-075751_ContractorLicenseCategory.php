<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContractorLicenseCategory extends Migration
{
	public function up()
	{
        $this->db->disableForeignKeyChecks();
        $this->forge->addField(
            [
                'contractor_license_category_id' =>[
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true,
                ],
                'max_contracts' =>[
                    'type' => 'INT',
                    'null'=>true,
                    'default'=>0,
                    'comment'=>'Maximum no. of contracts'
                ],
                'category_amount' =>[
                    'type' => 'DOUBLE',
                    'null'=>true,
                    'default'=>0
                ],
                'created_at datetime default current_timestamp',

            ]
        );
        $this->forge->addKey('contractor_license_category_id', true);
        $this->forge->createTable('contractor_license_categories');
	}

	public function down()
	{
		//
	}
}
