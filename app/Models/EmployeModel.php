<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeModel extends Model
{
    protected $table            = 'employes';
    protected $primaryKey       = 'id_employe';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'id_employe',
        'nom',
        'prenom',
        'date_naissance',
        'date_embauche',
        'salaire_base_personnalise',
        'nb_conges_restants',
        'nb_permissions_restantes',
        'id_poste'
    ];
}