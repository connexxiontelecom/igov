<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnContractorLicenseCategoriesTable extends Migration
{
	public function up()
	{
        $fields = [
            'category_name' => [
                'type' => 'TEXT',
                'null'=>true,
            ],

        ];
        $this->forge->addColumn('contractor_license_categories', $fields);
	}

	public function down()
	{
		//
	}
}
