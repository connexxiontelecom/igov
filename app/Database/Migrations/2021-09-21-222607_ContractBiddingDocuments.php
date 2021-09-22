<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContractBiddingDocuments extends Migration
{
	public function up()
	{
        $this->db->disableForeignKeyChecks();
        $this->forge->addField(
            [
                'contract_bidding_doc_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true,
                ],

                'contract_bidding_bid_id' =>[
                    'type' => 'INT',
                ],

                'contract_bidding_title' =>[
                    'type' => 'TEXT',
                    'null'=>true,
                ],
                'contract_bidding_document' =>[
                    'type' => 'TEXT',
                    'null'=>true,
                ],
                'contract_bidding_comment' =>[
                    'type' => 'TEXT',
                    'null'=>true,
                ],

                'created_at datetime default current_timestamp',
            ]
        );
        $this->forge->addKey('contract_bidding_doc_id', true);
        $this->forge->createTable('contract_bidding_documents');
	}

	public function down()
	{
		//
	}
}
