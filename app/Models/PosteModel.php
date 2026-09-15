<?php

namespace App\Models;

use CodeIgniter\Model;

class PosteModel extends Model
{
    protected $table            = 'postes';
    protected $primaryKey       = 'id_poste';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'libelle',
        'salaire_base_poste'
    ];
}