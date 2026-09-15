<?php

namespace App\Controllers;

use App\Models\AvanceModel;
use App\Models\EmployeModel;

class AvanceController extends BaseController
{
    protected $avanceModel;
    protected $employeModel;

    public function __construct()
    {
        $this->avanceModel = new AvanceModel();
        $this->employeModel = new EmployeModel();
    }

    public function index()
    {
        $builder = $this->avanceModel
            ->select('avances.*, employes.nom, employes.prenom')
            ->join('employes', 'employes.id_employe = avances.id_employe');

        $employe = $this->request->getGet('id_employe');
        $motif = $this->request->getGet('motif');

        if (!empty($employe)) {
            $builder->where('avances.id_employe', $employe);
        }

        if (!empty($motif)) {
            $builder->like('avances.motif', $motif);
        }

        $data = [
            'avances' => $builder->orderBy('avances.date_avance', 'DESC')->findAll(),
            'employes' => $this->employeModel->orderBy('nom', 'ASC')->findAll(),
            'filtre_employe' => $employe,
            'filtre_motif' => $motif
        ];

        return view('avances/index', $data);
    }

    public function new()
    {
        $data = [
            'avance' => null,
            'employes' => $this->employeModel->orderBy('nom', 'ASC')->findAll(),
            'action' => '/avances/create',
            'title' => 'Ajouter une avance'
        ];

        return view('avances/form', $data);
    }

    public function create()
    {
        $date = $this->request->getPost('date_avance');
        $jour = (int) date('d', strtotime($date));

        if ($jour < 20) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une avance peut être enregistrée uniquement à partir du 20 du mois.');
        }

        $data = [
            'montant' => $this->request->getPost('montant'),
            'date_avance' => $date,
            'motif' => $this->request->getPost('motif'),
            'id_employe' => $this->request->getPost('id_employe')
        ];

        $this->avanceModel->insert($data);

        return redirect()->to('/avances')
            ->with('success', 'Avance ajoutée avec succès.');
    }

    public function edit($id)
    {
        $avance = $this->avanceModel->find($id);

        if (!$avance) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Avance introuvable'
            );
        }

        $data = [
            'avance' => $avance,
            'employes' => $this->employeModel->orderBy('nom', 'ASC')->findAll(),
            'action' => '/avances/update/' . $id,
            'title' => 'Modifier une avance'
        ];

        return view('avances/form', $data);
    }

    public function update($id)
    {
        $date = $this->request->getPost('date_avance');
        $jour = (int) date('d', strtotime($date));

        if ($jour < 20) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une avance peut être enregistrée uniquement à partir du 20 du mois.');
        }

        $data = [
            'montant' => $this->request->getPost('montant'),
            'date_avance' => $date,
            'motif' => $this->request->getPost('motif'),
            'id_employe' => $this->request->getPost('id_employe')
        ];

        $this->avanceModel->update($id, $data);

        return redirect()->to('/avances')
            ->with('success', 'Avance modifiée avec succès.');
    }

    public function delete($id)
    {
        $this->avanceModel->delete($id);

        return redirect()->to('/avances')
            ->with('success', 'Avance supprimée avec succès.');
    }
}