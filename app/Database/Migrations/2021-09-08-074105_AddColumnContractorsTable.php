<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnContractorsTable extends Migration
{
	public function up()
	{
        $fields = [
            'contractor_status' => [
                'type' => 'INT',
                'null'=>true,
                'default'=>1,
                'comment'=>'0=Blacklist,1=whitelist'
            ],
            'contractor_license_status' => [
                'type' => 'INT',
                'null'=>true,
                'default'=>1,
                'comment'=>'1=active,0=inactive'
            ],
            'contractor_license_category_id' => [
                'type' => 'INT',
                'null'=>true,
            ],
            'contractor_black_list_comment' => [
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
