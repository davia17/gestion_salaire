<?php

namespace App\Models;

use CodeIgniter\Model;

class PrimeModel extends Model
{
    protected $table            = 'primes';
    protected $primaryKey       = 'id_prime';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'libelle',
        'montant',
        'date_prime',
        'id_employe'
    ];
}