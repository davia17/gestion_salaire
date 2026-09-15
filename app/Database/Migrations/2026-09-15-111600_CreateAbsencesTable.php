<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAbsencesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_absence' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'date_debut' => [
                'type' => 'DATE',
            ],

            'date_fin' => [
                'type' => 'DATE',
            ],

            'type' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
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

        $this->forge->addKey('id_absence', true);

        $this->forge->addForeignKey(
            'id_employe',
            'employes',
            'id_employe',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('absences');
    }

    public function down()
    {
        $this->forge->dropTable('absences');
    }
}