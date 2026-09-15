<?php

namespace App\Models;

use CodeIgniter\Model;

class PaieModel extends Model
{
    protected $table            = 'paies';
    protected $primaryKey       = 'id_paie';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'mois',
        'annee',
        'date_paiement',
        'salaire_brut',
        'deduction_cnap',
        'deduction_irsa',
        'prime_totale',
        'travail_ferie',
        'absence_jours',
        'total_avances',
        'salaire_net',
        'id_employe'
    ];
}