<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContractCategoriesTable extends Migration
{
	public function up()
	{
        $this->db->disableForeignKeyChecks();
        $this->forge->addField(
            [
                'contract_category_id' =>[
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true,
                ],
                'contract_cat_name' =>[
                    'type' => 'TEXT',
                    'null'=>true,
                ],
                'contract_cat_description' =>[
                    'type' => 'TEXT',
                    'null'=>true,
                ],
                'created_at datetime default current_timestamp',

            ]
        );
        $this->forge->addKey('contract_category_id', true);
        $this->forge->createTable('contract_categories');
	}

	public function down()
	{
		//
	}
}
