<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContractBoards extends Migration
{
	public function up()
	{
        $this->db->disableForeignKeyChecks();
        $this->forge->addField(
            [
                'contract_board_id' =>[
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true,
                ],
                'contract_b_contract_id' =>[
                    'type' => 'INT',
                    'null'=>true,
                ],
                'contract_b_employee_id' =>[
                    'type' => 'TEXT',
                    'null'=>true,
                ],
                'created_at datetime default current_timestamp',

            ]
        );
        $this->forge->addKey('contract_board_id', true);
        $this->forge->createTable('contract_boards');
	}

	public function down()
	{
		//
	}
}
