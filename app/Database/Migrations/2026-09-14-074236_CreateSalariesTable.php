<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSalariesTable extends Migration
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

            'employee_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'mois' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
                'unsigned'   => true,
            ],

            'annee' => [
                'type'       => 'INT',
                'constraint' => 4,
                'unsigned'   => true,
            ],

            'salaire_base' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],

            'prime' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0,
            ],

            'retenue' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0,
            ],

            'salaire_net' => [
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

        // Clé étrangère
        $this->forge->addForeignKey(
            'employee_id',
            'employees',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Création de la table
        $this->forge->createTable('salaries');
    }

    public function down()
    {
        $this->forge->dropTable('salaries');
    }
}