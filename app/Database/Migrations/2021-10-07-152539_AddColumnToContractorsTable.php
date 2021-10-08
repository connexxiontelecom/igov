<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnToContractorsTable extends Migration
{
	public function up()
	{
        $fields = [
            'contractor_license_id' => [
                'type' => 'INT',
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
