<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PostUpdate2 extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();
		$fields = [
			'p_stamps' => [
				'type' => 'TEXT',
			],

			'p_reviewed_by' => [
				'type' => 'INT',
			],
		];
		$this->forge->addColumn('posts', $fields);
	}

	public function down()
	{
		//
	}
}
