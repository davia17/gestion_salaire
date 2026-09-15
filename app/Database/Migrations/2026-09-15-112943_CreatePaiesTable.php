<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaiesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_paie' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'mois' => [
                'type'       => 'INT',
                'constraint' => 2,
                'unsigned'   => true,
            ],

            'annee' => [
                'type'       => 'INT',
                'constraint' => 4,
                'unsigned'   => true,
            ],

            'date_paiement' => [
                'type' => 'DATE',
                'null' => true,
            ],

            'salaire_brut' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0,
            ],

            'deduction_cnap' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0,
            ],

            'deduction_irsa' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0,
            ],

            'prime_totale' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0,
            ],

            'travail_ferie' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],

            'absence_jours' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],

            'total_avances' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0,
            ],

            'salaire_net' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0,
            ],

            'id_employe' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);

        // Clé primaire
        $this->forge->addKey('id_paie', true);

        // Empêcher deux paies pour le même employé et le même mois
        $this->forge->addKey(
            ['id_employe', 'mois', 'annee'],
            false,
            true
        );

        // Clé étrangère vers employes
        $this->forge->addForeignKey(
            'id_employe',
            'employes',
            'id_employe',
            'CASCADE',
            'CASCADE'
        );

        // Création de la table
        $this->forge->createTable('paies');
    }

    public function down()
    {
        $this->forge->dropTable('paies');
    }
}