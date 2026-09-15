<?php

namespace App\Models;

use CodeIgniter\Model;

class AvanceModel extends Model
{
    protected $table            = 'avances';
    protected $primaryKey       = 'id_avance';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'montant',
        'date_avance',
        'motif',
        'id_employe'
    ];
}