<?php

namespace App\Models;

use CodeIgniter\Model;

class EntrepriseModel extends Model
{
    protected $table            = 'entreprises';
    protected $primaryKey       = 'id_entreprise';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'nom',
        'adresse',
        'telephone',
        'email'
    ];
}