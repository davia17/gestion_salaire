<?php

namespace App\Controllers;

use App\Models\EmployeeModel;

class EmployeeController extends BaseController
{
    protected $employeeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
    }

    // READ - Afficher tous les employés
    public function index()
    {
        $data = [
            'employees' => $this->employeeModel->findAll()
        ];

        return view('employees/index', $data);
    }

    // CREATE - Afficher le formulaire d'ajout
    public function new()
    {
        return view('employees/form', [
            'employee' => null,
            'action'   => '/employees/create',
            'title'    => 'Ajouter un employé'
        ]);
    }

    // CREATE - Enregistrer un nouvel employé
    public function create()
    {
        $data = [
            'nom'          => $this->request->getPost('nom'),
            'prenom'       => $this->request->getPost('prenom'),
            'poste'        => $this->request->getPost('poste'),
            'salaire_base' => $this->request->getPost('salaire_base')
        ];

        $this->employeeModel->insert($data);

        return redirect()->to('/employees');
    }

    // UPDATE - Afficher le formulaire de modification
    public function edit($id)
    {
        $employee = $this->employeeModel->find($id);

        if (!$employee) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Employé introuvable'
            );
        }

        return view('employees/form', [
            'employee' => $employee,
            'action'   => '/employees/update/' . $id,
            'title'    => 'Modifier un employé'
        ]);
    }

    // UPDATE - Enregistrer les modifications
    public function update($id)
    {
        $data = [
            'nom'          => $this->request->getPost('nom'),
            'prenom'       => $this->request->getPost('prenom'),
            'poste'        => $this->request->getPost('poste'),
            'salaire_base' => $this->request->getPost('salaire_base')
        ];

        $this->employeeModel->update($id, $data);

        return redirect()->to('/employees');
    }

    // DELETE - Supprimer un employé
    public function delete($id)
    {
        $this->employeeModel->delete($id);

        return redirect()->to('/employees');
    }
}
