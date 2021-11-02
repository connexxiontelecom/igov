<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnToContractsTable extends Migration
{
	public function up()
	{
        $fields = [
            'contract_category_id' => [
                'type' => 'INT',
                'null'=>true,
            ],
        ];
        $this->forge->addColumn('contracts', $fields);
	}

	public function down()
	{
		//
	}
}
