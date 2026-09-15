<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrimesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_prime' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'libelle' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'montant' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],

            'date_prime' => [
                'type' => 'DATE',
            ],

            'id_employe' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);

        $this->forge->addKey('id_prime', true);

        $this->forge->addForeignKey(
            'id_employe',
            'employes',
            'id_employe',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('primes');
    }

    public function down()
    {
        $this->forge->dropTable('primes');
    }
}