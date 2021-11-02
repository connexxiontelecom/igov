<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPasswordColumnContractorsTable extends Migration
{
	public function up()
	{
        $fields = [
            'password' => [
                'type' => 'TEXT',
                'null'=>true,
            ],
        ];
        $this->forge->addColumn('contractors', $fields);
	}

	public function down()
	{
		//
	}
}
