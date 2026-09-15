<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_employe' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'prenom' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'date_naissance' => [
                'type' => 'DATE',
            ],

            'date_embauche' => [
                'type' => 'DATE',
            ],

            'salaire_base_personnalise' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],

            'nb_conges_restants' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 15,
            ],

            'nb_permissions_restantes' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 3,
            ],

            'id_poste' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addKey('id_employe', true);

        $this->forge->addForeignKey(
            'id_poste',
            'postes',
            'id_poste',
            'CASCADE',
            'RESTRICT'
        );

        $this->forge->createTable('employes');
    }

    public function down()
    {
        $this->forge->dropTable('employes');
    }
}