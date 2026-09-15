<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_poste' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'libelle' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'salaire_base_poste' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
        ]);

        $this->forge->addKey('id_poste', true);

        $this->forge->createTable('postes');
    }

    public function down()
    {
        $this->forge->dropTable('postes');
    }
}