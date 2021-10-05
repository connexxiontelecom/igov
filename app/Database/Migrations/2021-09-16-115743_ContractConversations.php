<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContractConversations extends Migration
{
	public function up()
	{
        $this->db->disableForeignKeyChecks();
        $this->forge->addField(
            [
                'contract_convo_id' =>[
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true,
                ],
                'contract_convo_contract_id' =>[
                    'type' => 'INT',
                    'null'=>true,
                ],
                'contract_convo_employee_id' =>[
                    'type' => 'INT',
                    'null'=>true,
                ],
                'contract_convo' =>[
                    'type' => 'TEXT',
                    'null'=>true,
                ],
                'created_at datetime default current_timestamp',

            ]
        );
        $this->forge->addKey('contract_convo_id', true);
        $this->forge->createTable('contract_conversations');
	}

	public function down()
	{
		//
	}
}
