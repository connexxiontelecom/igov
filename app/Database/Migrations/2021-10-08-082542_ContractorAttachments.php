<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContractorAttachments extends Migration
{
	public function up()
	{
        $this->db->disableForeignKeyChecks();
        $this->forge->addField(
            [
                'contractor_attachment_id' =>[
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true,
                ],
                'contractor_attach_contractor_id' =>[
                    'type' => 'INT',
                    'null'=>true,
                ],
                'contractor_attachment' =>[
                    'type' => 'TEXT',
                    'null'=>true,
                ],
                'created_at datetime default current_timestamp',

            ]
        );
        $this->forge->addKey('contractor_attachment_id', true);
        $this->forge->createTable('contractor_attachments');
	}

	public function down()
	{
		//
	}
}
