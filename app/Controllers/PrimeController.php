<?php

namespace App\Controllers;

use App\Models\PrimeModel;
use App\Models\EmployeModel;

class PrimeController extends BaseController
{
    protected $primeModel;
    protected $employeModel;

    public function __construct()
    {
        $this->primeModel = new PrimeModel();
        $this->employeModel = new EmployeModel();
    }

    public function index()
    {
        $builder = $this->primeModel
            ->select('primes.*, employes.nom, employes.prenom')
            ->join('employes', 'employes.id_employe = primes.id_employe');

        $employe = $this->request->getGet('id_employe');
        $libelle = $this->request->getGet('libelle');

        if (!empty($employe)) {
            $builder->where('primes.id_employe', $employe);
        }

        if (!empty($libelle)) {
            $builder->like('primes.libelle', $libelle);
        }

        $data = [
            'primes' => $builder
                ->orderBy('primes.date_prime', 'DESC')
                ->findAll(),
            'employes' => $this->employeModel
                ->orderBy('nom', 'ASC')
                ->findAll(),
            'filtre_employe' => $employe,
            'filtre_libelle' => $libelle
        ];

        return view('primes/index', $data);
    }

    public function new()
    {
        $data = [
            'prime' => null,
            'employes' => $this->employeModel
                ->orderBy('nom', 'ASC')
                ->findAll(),
            'action' => '/primes/create',
            'title' => 'Ajouter une prime'
        ];

        return view('primes/form', $data);
    }

    public function create()
    {
        $date = $this->request->getPost('date_prime');
        $idEmploye = $this->request->getPost('id_employe');

        $annee = date('Y', strtotime($date));

        $nombrePrimes = $this->primeModel
            ->where('id_employe', $idEmploye)
            ->where('YEAR(date_prime)', $annee, false)
            ->countAllResults();

        if ($nombrePrimes >= 3) {
            return redirect()->back()
                ->withInput()
                ->with(
                    'error',
                    'Cet employé a déjà atteint la limite de 3 primes pour cette année.'
                );
        }

        $data = [
            'libelle' => $this->request->getPost('libelle'),
            'montant' => $this->request->getPost('montant'),
            'date_prime' => $date,
            'id_employe' => $idEmploye
        ];

        $this->primeModel->insert($data);

        return redirect()->to('/primes')
            ->with('success', 'Prime ajoutée avec succès.');
    }

    public function edit($id)
    {
        $prime = $this->primeModel->find($id);

        if (!$prime) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Prime introuvable'
            );
        }

        $data = [
            'prime' => $prime,
            'employes' => $this->employeModel
                ->orderBy('nom', 'ASC')
                ->findAll(),
            'action' => '/primes/update/' . $id,
            'title' => 'Modifier une prime'
        ];

        return view('primes/form', $data);
    }

    public function update($id)
    {
        $prime = $this->primeModel->find($id);

        if (!$prime) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Prime introuvable'
            );
        }

        $date = $this->request->getPost('date_prime');
        $idEmploye = $this->request->getPost('id_employe');

        $annee = date('Y', strtotime($date));

        $nombrePrimes = $this->primeModel
            ->where('id_employe', $idEmploye)
            ->where('YEAR(date_prime)', $annee, false)
            ->where('id_prime !=', $id)
            ->countAllResults();

        if ($nombrePrimes >= 3) {
            return redirect()->back()
                ->withInput()
                ->with(
                    'error',
                    'Cet employé a déjà atteint la limite de 3 primes pour cette année.'
                );
        }

        $data = [
            'libelle' => $this->request->getPost('libelle'),
            'montant' => $this->request->getPost('montant'),
            'date_prime' => $date,
            'id_employe' => $idEmploye
        ];

        $this->primeModel->update($id, $data);

        return redirect()->to('/primes')
            ->with('success', 'Prime modifiée avec succès.');
    }

    public function delete($id)
    {
        $prime = $this->primeModel->find($id);

        if (!$prime) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Prime introuvable'
            );
        }

        $this->primeModel->delete($id);

        return redirect()->to('/primes')
            ->with('success', 'Prime supprimée avec succès.');
    }
}