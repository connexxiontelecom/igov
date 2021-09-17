<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContractsTable extends Migration
{
	public function up()
	{
        $this->db->disableForeignKeyChecks();
        $this->forge->addField(
            [
                'contract_id' =>[
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true,
                ],
                'contract_title' =>[
                    'type' => 'TEXT',
                    'null'=>true,
                ],
                'contract_scope' =>[
                    'type' => 'TEXT',
                    'null'=>true,
                ],
                'contract_eligibility' =>[
                    'type' => 'TEXT',
                    'null'=>true,
                ],
                'contract_published_by' =>[
                    'type' => 'INT',
                    'null'=>true,
                ],
                'contract_published_date' =>[
                    'type' => 'TEXT',
                    'null'=>true,
                ],
                'contract_certificate' =>[
                    'type' => 'TEXT',
                    'null'=>true,
                    'comment'=>'Certificate of No Objection'
                ],
                'contract_opening_date' =>[
                    'type' => 'DATE',
                    'null'=>true,
                ],
                'contract_closing_date' =>[
                    'type' => 'DATE',
                    'null'=>true,
                ],
                'contract_status' =>[
                    'type' => 'INT',
                    'null'=>true,
                    'default'=>0,
                    'comment'=>'1=open,0=unpublished,2=closed'
                ],
                'contract_slug' =>[
                    'type' => 'TEXT',
                    'null'=>true,
                ],
                'created_at datetime default current_timestamp',

            ]
        );
        $this->forge->addKey('contract_id', true);
        $this->forge->createTable('contracts');
	}

	public function down()
	{
		//
	}
}
