<?php

namespace App\Controllers;

use App\Models\EmployeModel;
use App\Models\PosteModel;

class EmployeController extends BaseController
{
    protected $employeModel;
    protected $posteModel;

    public function __construct()
    {
        $this->employeModel = new EmployeModel();
        $this->posteModel   = new PosteModel();
    }

    // READ - Afficher tous les employés
    public function index()
    {
        $data = [
            'employes' => $this->employeModel
                ->select('employes.*, postes.libelle AS poste')
                ->join('postes', 'postes.id_poste = employes.id_poste')
                ->findAll()
        ];

        return view('employes/index', $data);
    }

    // CREATE - Afficher le formulaire
    public function new()
    {
        $data = [
            'employe' => null,
            'postes'  => $this->posteModel->findAll(),
            'action'  => '/employes/create',
            'title'   => 'Ajouter un employé'
        ];

        return view('employes/form', $data);
    }

    // CREATE - Enregistrer un employé
    public function create()
    {
        $data = [
            'id_employe'                 => $this->request->getPost('id_employe'),
            'nom'                        => $this->request->getPost('nom'),
            'prenom'                     => $this->request->getPost('prenom'),
            'date_naissance'             => $this->request->getPost('date_naissance'),
            'date_embauche'              => $this->request->getPost('date_embauche'),
            'salaire_base_personnalise'  => $this->request->getPost('salaire_base_personnalise'),
            'id_poste'                   => $this->request->getPost('id_poste')
        ];

        $this->employeModel->insert($data);

        return redirect()->to('/employes');
    }

    // UPDATE - Afficher le formulaire
    public function edit($id)
    {
        $employe = $this->employeModel->find($id);

        if (!$employe) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Employé introuvable'
            );
        }

        $data = [
            'employe' => $employe,
            'postes'  => $this->posteModel->findAll(),
            'action'  => '/employes/update/' . $id,
            'title'   => 'Modifier un employé'
        ];

        return view('employes/form', $data);
    }

    // UPDATE - Enregistrer les modifications
    public function update($id)
    {
        $data = [
            'nom'                       => $this->request->getPost('nom'),
            'prenom'                    => $this->request->getPost('prenom'),
            'date_naissance'            => $this->request->getPost('date_naissance'),
            'date_embauche'             => $this->request->getPost('date_embauche'),
            'salaire_base_personnalise' => $this->request->getPost('salaire_base_personnalise'),
            'id_poste'                  => $this->request->getPost('id_poste')
        ];

        $this->employeModel->update($id, $data);

        return redirect()->to('/employes');
    }

    // DELETE - Supprimer un employé
    public function delete($id)
    {
        $this->employeModel->delete($id);

        return redirect()->to('/employes');
    }
}