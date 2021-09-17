<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContractAttachments extends Migration
{
	public function up()
	{
        $this->db->disableForeignKeyChecks();
        $this->forge->addField(
            [
                'contract_attachment_id' =>[
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true,
                ],
                'contract_att_contract_id' =>[
                    'type' => 'INT',
                    'null'=>true,
                ],
                'contract_att_attachment' =>[
                    'type' => 'TEXT',
                    'null'=>true,
                ],
                'created_at datetime default current_timestamp',

            ]
        );
        $this->forge->addKey('contract_attachment_id', true);
        $this->forge->createTable('contract_attachments');
	}

	public function down()
	{
		//
	}
}
