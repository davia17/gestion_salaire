<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsenceModel extends Model
{
    protected $table            = 'absences';
    protected $primaryKey       = 'id_absence';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'date_debut',
        'date_fin',
        'type',
        'motif',
        'id_employe'
    ];
}