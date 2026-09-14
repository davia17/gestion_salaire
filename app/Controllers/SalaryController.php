<?php

namespace App\Controllers;

use App\Models\SalaryModel;
use App\Models\EmployeeModel;

class SalaryController extends BaseController
{
    protected $salaryModel;
    protected $employeeModel;

    public function __construct()
    {
        $this->salaryModel = new SalaryModel();
        $this->employeeModel = new EmployeeModel();
    }

    // READ - Afficher tous les salaires
    public function index()
    {
        $salaries = $this->salaryModel
            ->select('salaries.*, employees.nom, employees.prenom')
            ->join('employees', 'employees.id = salaries.employee_id')
            ->findAll();

        $data = [
            'salaries' => $salaries
        ];

        return view('salaries/index', $data);
    }

    // CREATE - Afficher le formulaire
    public function new()
    {
        $data = [
            'employees' => $this->employeeModel->findAll(),
            'salary'    => null,
            'action'    => '/salaries/create',
            'title'     => 'Ajouter un salaire'
        ];

        return view('salaries/form', $data);
    }

    // CREATE - Enregistrer un salaire
    public function create()
    {
        $salaireBase = (float) $this->request->getPost('salaire_base');
        $prime       = (float) $this->request->getPost('prime');
        $retenue     = (float) $this->request->getPost('retenue');

        $salaireNet = $salaireBase + $prime - $retenue;

        $data = [
            'employee_id'  => $this->request->getPost('employee_id'),
            'mois'         => $this->request->getPost('mois'),
            'annee'        => $this->request->getPost('annee'),
            'salaire_base' => $salaireBase,
            'prime'        => $prime,
            'retenue'      => $retenue,
            'salaire_net'  => $salaireNet
        ];

        $this->salaryModel->insert($data);

        return redirect()->to('/salaries');
    }

    // UPDATE - Afficher le formulaire de modification
    public function edit($id)
    {
        $salary = $this->salaryModel->find($id);

        if (!$salary) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Salaire introuvable'
            );
        }

        $data = [
            'employees' => $this->employeeModel->findAll(),
            'salary'    => $salary,
            'action'    => '/salaries/update/' . $id,
            'title'     => 'Modifier un salaire'
        ];

        return view('salaries/form', $data);
    }

    // UPDATE - Enregistrer les modifications
    public function update($id)
    {
        $salaireBase = (float) $this->request->getPost('salaire_base');
        $prime       = (float) $this->request->getPost('prime');
        $retenue     = (float) $this->request->getPost('retenue');

        $salaireNet = $salaireBase + $prime - $retenue;

        $data = [
            'employee_id'  => $this->request->getPost('employee_id'),
            'mois'         => $this->request->getPost('mois'),
            'annee'        => $this->request->getPost('annee'),
            'salaire_base' => $salaireBase,
            'prime'        => $prime,
            'retenue'      => $retenue,
            'salaire_net'  => $salaireNet
        ];

        $this->salaryModel->update($id, $data);

        return redirect()->to('/salaries');
    }

    // DELETE - Supprimer un salaire
    public function delete($id)
    {
        $this->salaryModel->delete($id);

        return redirect()->to('/salaries');
    }
}