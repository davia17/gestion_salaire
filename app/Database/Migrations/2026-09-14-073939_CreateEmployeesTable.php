<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'prenom' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'poste' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'salaire_base' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Clé primaire
        $this->forge->addKey('id', true);

        // Création de la table
        $this->forge->createTable('employees');
    }

    public function down()
    {
        // Supprimer la table si on annule la migration
        $this->forge->dropTable('employees');
    }
}