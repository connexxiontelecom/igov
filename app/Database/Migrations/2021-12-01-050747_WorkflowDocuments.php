<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class WorkflowDocuments extends Migration
{
	public function up()
	{
		//
		$this->db->disableForeignKeyChecks();
		$this->forge->addField(
			[
				'wd_id' => [
					'type' => 'INT',
					'constraint' => 11,
					'auto_increment' => true,
				],
				
				'wd_doc' =>[
					'type' => 'TEXT',
				],
				
				'wd_employee_id' =>[
					'type' => 'INT',
				],
				
				'wd_date' =>[
					'type' => 'TEXT',
				],
				
				
				'created_at datetime default current_timestamp',
			]
		);
		$this->forge->addKey('wd_id', true);
		$this->forge->createTable('workflow_documents');
	}

	public function down()
	{
		//
	}
}
