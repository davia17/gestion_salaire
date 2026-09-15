<?php

namespace App\Controllers;

use App\Models\PaieModel;
use App\Models\EmployeModel;
use App\Models\PrimeModel;
use App\Models\AbsenceModel;
use App\Models\AvanceModel;

class PaieController extends BaseController
{
    protected $paieModel;
    protected $employeModel;
    protected $primeModel;
    protected $absenceModel;
    protected $avanceModel;

    public function __construct()
    {
        $this->paieModel = new PaieModel();
        $this->employeModel = new EmployeModel();
        $this->primeModel = new PrimeModel();
        $this->absenceModel = new AbsenceModel();
        $this->avanceModel = new AvanceModel();
    }

    public function index()
    {
        $builder = $this->paieModel
            ->select('paies.*, employes.nom, employes.prenom')
            ->join('employes', 'employes.id_employe = paies.id_employe');

        $employe = $this->request->getGet('id_employe');
        $mois = $this->request->getGet('mois');
        $annee = $this->request->getGet('annee');

        if (!empty($employe)) {
            $builder->where('paies.id_employe', $employe);
        }

        if (!empty($mois)) {
            $builder->where('paies.mois', $mois);
        }

        if (!empty($annee)) {
            $builder->where('paies.annee', $annee);
        }

        $data = [
            'paies' => $builder
                ->orderBy('paies.annee', 'DESC')
                ->orderBy('paies.mois', 'DESC')
                ->findAll(),

            'employes' => $this->employeModel
                ->orderBy('nom', 'ASC')
                ->findAll(),

            'filtre_employe' => $employe,
            'filtre_mois' => $mois,
            'filtre_annee' => $annee
        ];

        return view('paies/index', $data);
    }

    public function new()
    {
        $data = [
            'paie' => null,
            'employes' => $this->employeModel
                ->orderBy('nom', 'ASC')
                ->findAll(),
            'action' => '/paies/create',
            'title' => 'Calculer une paie'
        ];

        return view('paies/form', $data);
    }

    public function create()
    {
        $idEmploye = $this->request->getPost('id_employe');
        $mois = (int) $this->request->getPost('mois');
        $annee = (int) $this->request->getPost('annee');
        $datePaiement = $this->request->getPost('date_paiement');

        if (empty($idEmploye) || empty($mois) || empty($annee)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tous les champs obligatoires doivent être remplis.');
        }

        if ($mois < 1 || $mois > 12) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Le mois sélectionné est invalide.');
        }

        $paieExiste = $this->paieModel
            ->where('id_employe', $idEmploye)
            ->where('mois', $mois)
            ->where('annee', $annee)
            ->first();

        if ($paieExiste) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une paie existe déjà pour cet employé pour cette période.');
        }

        $calcul = $this->calculerPaie(
            $idEmploye,
            $mois,
            $annee
        );

        if ($calcul === null) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Employé introuvable.');
        }

        $data = [
            'mois' => $mois,
            'annee' => $annee,
            'date_paiement' => !empty($datePaiement) ? $datePaiement : null,
            'salaire_brut' => $calcul['salaire_brut'],
            'deduction_cnap' => $calcul['deduction_cnap'],
            'deduction_irsa' => $calcul['deduction_irsa'],
            'prime_totale' => $calcul['prime_totale'],
            'travail_ferie' => $calcul['travail_ferie'],
            'absence_jours' => $calcul['absence_jours'],
            'total_avances' => $calcul['total_avances'],
            'salaire_net' => $calcul['salaire_net'],
            'id_employe' => $idEmploye
        ];

        $this->paieModel->insert($data);

        return redirect()->to('/paies')
            ->with('success', 'Paie calculée et enregistrée avec succès.');
    }

    public function edit($id)
    {
        $paie = $this->paieModel->find($id);

        if (!$paie) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Paie introuvable'
            );
        }

        $data = [
            'paie' => $paie,
            'employes' => $this->employeModel
                ->orderBy('nom', 'ASC')
                ->findAll(),
            'action' => '/paies/update/' . $id,
            'title' => 'Modifier une paie'
        ];

        return view('paies/form', $data);
    }

    public function update($id)
    {
        $paie = $this->paieModel->find($id);

        if (!$paie) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Paie introuvable'
            );
        }

        $idEmploye = $this->request->getPost('id_employe');
        $mois = (int) $this->request->getPost('mois');
        $annee = (int) $this->request->getPost('annee');
        $datePaiement = $this->request->getPost('date_paiement');

        if (empty($idEmploye) || empty($mois) || empty($annee)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tous les champs obligatoires doivent être remplis.');
        }

        if ($mois < 1 || $mois > 12) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Le mois sélectionné est invalide.');
        }

        $paieExiste = $this->paieModel
            ->where('id_employe', $idEmploye)
            ->where('mois', $mois)
            ->where('annee', $annee)
            ->where('id_paie !=', $id)
            ->first();

        if ($paieExiste) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une autre paie existe déjà pour cet employé pour cette période.');
        }

        $calcul = $this->calculerPaie(
            $idEmploye,
            $mois,
            $annee
        );

        if ($calcul === null) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Employé introuvable.');
        }

        $data = [
            'mois' => $mois,
            'annee' => $annee,
            'date_paiement' => !empty($datePaiement) ? $datePaiement : null,
            'salaire_brut' => $calcul['salaire_brut'],
            'deduction_cnap' => $calcul['deduction_cnap'],
            'deduction_irsa' => $calcul['deduction_irsa'],
            'prime_totale' => $calcul['prime_totale'],
            'travail_ferie' => $calcul['travail_ferie'],
            'absence_jours' => $calcul['absence_jours'],
            'total_avances' => $calcul['total_avances'],
            'salaire_net' => $calcul['salaire_net'],
            'id_employe' => $idEmploye
        ];

        $this->paieModel->update($id, $data);

        return redirect()->to('/paies')
            ->with('success', 'Paie recalculée avec succès.');
    }

    public function delete($id)
    {
        $paie = $this->paieModel->find($id);

        if (!$paie) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Paie introuvable'
            );
        }

        $this->paieModel->delete($id);

        return redirect()->to('/paies')
            ->with('success', 'Paie supprimée avec succès.');
    }

    private function calculerPaie($idEmploye, $mois, $annee)
    {
        $employe = $this->employeModel->find($idEmploye);

        if (!$employe) {
            return null;
        }

        $salaireBase = (float) $employe['salaire_base_personnalise'];

        $dateDebut = sprintf('%04d-%02d-01', $annee, $mois);
        $dateFin = date('Y-m-t', strtotime($dateDebut));

        $primes = $this->primeModel
            ->where('id_employe', $idEmploye)
            ->where('date_prime >=', $dateDebut)
            ->where('date_prime <=', $dateFin)
            ->findAll();

        $primeTotale = 0;

        foreach ($primes as $prime) {
            $primeTotale += (float) $prime['montant'];
        }

        $absences = $this->absenceModel
            ->where('id_employe', $idEmploye)
            ->where('type', 'Absence')
            ->where('date_debut <=', $dateFin)
            ->where('date_fin >=', $dateDebut)
            ->findAll();

        $absenceJours = 0;

        foreach ($absences as $absence) {
            $absenceDebut = max($absence['date_debut'], $dateDebut);
            $absenceFin = min($absence['date_fin'], $dateFin);

            $absenceJours += $this->calculerJours(
                $absenceDebut,
                $absenceFin
            );
        }

        $avances = $this->avanceModel
            ->where('id_employe', $idEmploye)
            ->where('date_avance >=', $dateDebut)
            ->where('date_avance <=', $dateFin)
            ->findAll();

        $totalAvances = 0;

        foreach ($avances as $avance) {
            $totalAvances += (float) $avance['montant'];
        }

        $travailFerie = 0;

        $gainFerie = $travailFerie * ($salaireBase / 30) * 1.05;

        $deductionAbsence = $absenceJours * ($salaireBase / 30);

        $salaireBrut = $salaireBase
            + $primeTotale
            + $gainFerie
            - $deductionAbsence;

        $deductionCnap = min(
            $salaireBrut * 0.01,
            13000
        );

        $deductionIrsa = $this->calculerIrsa($salaireBrut);

        $salaireNet = $salaireBrut
            - $deductionCnap
            - $deductionIrsa
            - $totalAvances;

        return [
            'salaire_brut' => round($salaireBrut, 2),
            'deduction_cnap' => round($deductionCnap, 2),
            'deduction_irsa' => round($deductionIrsa, 2),
            'prime_totale' => round($primeTotale, 2),
            'travail_ferie' => $travailFerie,
            'absence_jours' => $absenceJours,
            'total_avances' => round($totalAvances, 2),
            'salaire_net' => round($salaireNet, 2)
        ];
    }

    private function calculerIrsa($salaireBrut)
    {
        if ($salaireBrut <= 350000) {
            return 0;
        }

        if ($salaireBrut <= 400000) {
            return max(0, ($salaireBrut * 0.05) - 17500);
        }

        if ($salaireBrut <= 500000) {
            return max(0, ($salaireBrut * 0.10) - 37500);
        }

        if ($salaireBrut <= 600000) {
            return max(0, ($salaireBrut * 0.15) - 62500);
        }

        return max(0, ($salaireBrut * 0.20) - 92500);
    }

    private function calculerJours($dateDebut, $dateFin)
    {
        $debut = new \DateTime($dateDebut);
        $fin = new \DateTime($dateFin);

        return $debut->diff($fin)->days + 1;
    }
}