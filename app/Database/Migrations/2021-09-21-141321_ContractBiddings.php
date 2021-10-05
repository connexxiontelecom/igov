<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContractBiddings extends Migration
{
	public function up()
	{
        $this->db->disableForeignKeyChecks();
        $this->forge->addField(
            [
                'contract_bidding_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true,
                ],

                'contract_bd_contractor_id' =>[
                    'type' => 'INT',
                ],

                'contract_bd_contract_id' =>[
                    'type' => 'INT',
                ],

                'contract_bd_status' =>[
                    'type' => 'INT',
                    'default'=>0,
                    'comment'=>'0=pending,1=approved,2=declined'
                ],

                'contract_bd_updated_by' =>[
                    'type' => 'INT',
                    'null'=>true,
                ],

                'contract_bd_date_updated' =>[
                    'type' => 'DATETIME',
                    'null'=>true
                ],

                'created_at datetime default current_timestamp',
            ]
        );
        $this->forge->addKey('contract_bidding_id', true);
        $this->forge->createTable('contract_biddings');
	}

	public function down()
	{
		//
	}
}
