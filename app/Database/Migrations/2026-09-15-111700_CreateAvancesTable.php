<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAvancesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_avance' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'montant' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],

            'date_avance' => [
                'type' => 'DATE',
            ],

            'motif' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'id_employe' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);

        $this->forge->addKey('id_avance', true);

        $this->forge->addForeignKey(
            'id_employe',
            'employes',
            'id_employe',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('avances');
    }

    public function down()
    {
        $this->forge->dropTable('avances');
    }
}