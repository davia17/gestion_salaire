<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEntreprisesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_entreprise' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'adresse' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'telephone' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);

        $this->forge->addKey('id_entreprise', true);

        $this->forge->createTable('entreprises');
    }

    public function down()
    {
        $this->forge->dropTable('entreprises');
    }
}