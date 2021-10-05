<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContractorLicenses extends Migration
{
	public function up()
	{
        $this->db->disableForeignKeyChecks();
        $this->forge->addField(
            [
                'contractor_license_id' =>[
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true,
                ],
                'contractor_id' =>[
                    'type' => 'INT',
                    'null'=>true,
                ],
                'contractor_license_category_id' =>[
                    'type' => 'INT',
                    'null'=>true,
                ],
                'contractor_license_start_date' =>[
                    'type' => 'DATE',
                    'null'=>true,
                ],
                'contractor_license_end_date' =>[
                    'type' => 'DATE',
                    'null'=>true,
                ],
                'license_amount' =>[
                    'type' => 'DOUBLE',
                    'null'=>true,
                    'default'=>0
                ],
                'created_at datetime default current_timestamp',

            ]
        );
        $this->forge->addKey('contractor_license_id', true);
        $this->forge->createTable('contractor_licenses');
	}

	public function down()
	{
		//
	}
}
