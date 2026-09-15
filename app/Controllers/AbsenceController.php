<?php

namespace App\Controllers;

use App\Models\AbsenceModel;
use App\Models\EmployeModel;

class AbsenceController extends BaseController
{
    protected $absenceModel;
    protected $employeModel;

    public function __construct()
    {
        $this->absenceModel = new AbsenceModel();
        $this->employeModel = new EmployeModel();
    }

    public function index()
    {
        $builder = $this->absenceModel
            ->select('absences.*, employes.nom, employes.prenom')
            ->join('employes', 'employes.id_employe = absences.id_employe');

        $employe = $this->request->getGet('id_employe');
        $type = $this->request->getGet('type');

        if (!empty($employe)) {
            $builder->where('absences.id_employe', $employe);
        }

        if (!empty($type)) {
            $builder->where('absences.type', $type);
        }

        $data = [
            'absences' => $builder
                ->orderBy('absences.date_debut', 'DESC')
                ->findAll(),
            'employes' => $this->employeModel
                ->orderBy('nom', 'ASC')
                ->findAll(),
            'filtre_employe' => $employe,
            'filtre_type' => $type
        ];

        return view('absences/index', $data);
    }

    public function new()
    {
        $data = [
            'absence' => null,
            'employes' => $this->employeModel
                ->orderBy('nom', 'ASC')
                ->findAll(),
            'action' => '/absences/create',
            'title' => 'Ajouter une absence'
        ];

        return view('absences/form', $data);
    }

    public function create()
    {
        $dateDebut = $this->request->getPost('date_debut');
        $dateFin = $this->request->getPost('date_fin');
        $type = $this->request->getPost('type');
        $idEmploye = $this->request->getPost('id_employe');

        if (empty($dateDebut) || empty($dateFin) || empty($type) || empty($idEmploye)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tous les champs obligatoires doivent être remplis.');
        }

        if ($dateFin < $dateDebut) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'La date de fin doit être supérieure ou égale à la date de début.');
        }

        $anneeActuelle = date('Y');

        if (
            date('Y', strtotime($dateDebut)) != $anneeActuelle ||
            date('Y', strtotime($dateFin)) != $anneeActuelle
        ) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Les absences doivent être enregistrées pour l\'année en cours.');
        }

        $nombreJours = $this->calculerJours($dateDebut, $dateFin);

        if ($type === 'Congé') {
            return $this->creerConge(
                $idEmploye,
                $dateDebut,
                $dateFin,
                $nombreJours
            );
        }

        if ($type === 'Permission') {
            return $this->creerPermission(
                $idEmploye,
                $dateDebut,
                $dateFin,
                $nombreJours
            );
        }

        $data = [
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'type' => 'Absence',
            'motif' => $this->request->getPost('motif'),
            'id_employe' => $idEmploye
        ];

        $this->absenceModel->insert($data);

        return redirect()->to('/absences')
            ->with('success', 'Absence ajoutée avec succès.');
    }

    public function edit($id)
    {
        $absence = $this->absenceModel->find($id);

        if (!$absence) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Absence introuvable'
            );
        }

        $data = [
            'absence' => $absence,
            'employes' => $this->employeModel
                ->orderBy('nom', 'ASC')
                ->findAll(),
            'action' => '/absences/update/' . $id,
            'title' => 'Modifier une absence'
        ];

        return view('absences/form', $data);
    }

    public function update($id)
    {
        $absence = $this->absenceModel->find($id);

        if (!$absence) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Absence introuvable'
            );
        }

        if ($absence['type'] === 'Congé') {
            $this->restaurerConge($absence);
        }

        if ($absence['type'] === 'Permission') {
            $this->restaurerPermission($absence);
        }

        $dateDebut = $this->request->getPost('date_debut');
        $dateFin = $this->request->getPost('date_fin');
        $type = $this->request->getPost('type');
        $idEmploye = $this->request->getPost('id_employe');

        if ($dateFin < $dateDebut) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'La date de fin doit être supérieure ou égale à la date de début.');
        }

        $anneeActuelle = date('Y');

        if (
            date('Y', strtotime($dateDebut)) != $anneeActuelle ||
            date('Y', strtotime($dateFin)) != $anneeActuelle
        ) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Les absences doivent être enregistrées pour l\'année en cours.');
        }

        $nombreJours = $this->calculerJours($dateDebut, $dateFin);

        if ($type === 'Congé') {
            $conges = $this->absenceModel
                ->where('id_employe', $idEmploye)
                ->where('type', 'Congé')
                ->where('YEAR(date_debut)', $anneeActuelle, false)
                ->where('id_absence !=', $id)
                ->countAllResults();

            if ($conges >= 1) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Cet employé possède déjà un congé pour cette année.');
            }

            if ($nombreJours > 15) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Un congé ne peut pas dépasser 15 jours.');
            }

            $this->modifierQuotaConge($idEmploye, $nombreJours);

        } elseif ($type === 'Permission') {

            $permissions = $this->absenceModel
                ->where('id_employe', $idEmploye)
                ->where('type', 'Permission')
                ->where('YEAR(date_debut)', $anneeActuelle, false)
                ->where('id_absence !=', $id)
                ->countAllResults();

            if ($permissions >= 3) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Cet employé a déjà atteint la limite de 3 permissions pour cette année.');
            }

            if ($nombreJours > 4) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Une permission ne peut pas dépasser 4 jours.');
            }

            $this->modifierQuotaPermission($idEmploye, $nombreJours);

        }

        $data = [
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'type' => $type,
            'motif' => $this->request->getPost('motif'),
            'id_employe' => $idEmploye
        ];

        $this->absenceModel->update($id, $data);

        return redirect()->to('/absences')
            ->with('success', 'Absence modifiée avec succès.');
    }

    public function delete($id)
    {
        $absence = $this->absenceModel->find($id);

        if (!$absence) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Absence introuvable'
            );
        }

        if ($absence['type'] === 'Congé') {
            $this->restaurerConge($absence);
        }

        if ($absence['type'] === 'Permission') {
            $this->restaurerPermission($absence);
        }

        $this->absenceModel->delete($id);

        return redirect()->to('/absences')
            ->with('success', 'Absence supprimée avec succès.');
    }

    private function calculerJours($dateDebut, $dateFin)
    {
        $debut = new \DateTime($dateDebut);
        $fin = new \DateTime($dateFin);

        return $debut->diff($fin)->days + 1;
    }

    private function creerConge($idEmploye, $dateDebut, $dateFin, $nombreJours)
    {
        $annee = date('Y');

        $conges = $this->absenceModel
            ->where('id_employe', $idEmploye)
            ->where('type', 'Congé')
            ->where('YEAR(date_debut)', $annee, false)
            ->countAllResults();

        if ($conges >= 1) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cet employé possède déjà un congé pour cette année.');
        }

        if ($nombreJours > 15) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Un congé ne peut pas dépasser 15 jours.');
        }

        $employe = $this->employeModel->find($idEmploye);

        if (!$employe || $employe['nb_conges_restants'] < $nombreJours) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Le nombre de jours de congé disponibles est insuffisant.');
        }

        $data = [
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'type' => 'Congé',
            'motif' => $this->request->getPost('motif'),
            'id_employe' => $idEmploye
        ];

        $this->absenceModel->insert($data);

        $this->employeModel->update($idEmploye, [
            'nb_conges_restants' => $employe['nb_conges_restants'] - $nombreJours
        ]);

        return redirect()->to('/absences')
            ->with('success', 'Congé ajouté avec succès.');
    }

    private function creerPermission($idEmploye, $dateDebut, $dateFin, $nombreJours)
    {
        $annee = date('Y');

        $permissions = $this->absenceModel
            ->where('id_employe', $idEmploye)
            ->where('type', 'Permission')
            ->where('YEAR(date_debut)', $annee, false)
            ->countAllResults();

        if ($permissions >= 3) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Cet employé a déjà atteint la limite de 3 permissions pour cette année.');
        }

        if ($nombreJours > 4) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une permission ne peut pas dépasser 4 jours.');
        }

        $employe = $this->employeModel->find($idEmploye);

        if (!$employe || $employe['nb_permissions_restantes'] <= 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Le nombre de permissions disponibles est insuffisant.');
        }

        $data = [
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'type' => 'Permission',
            'motif' => $this->request->getPost('motif'),
            'id_employe' => $idEmploye
        ];

        $this->absenceModel->insert($data);

        $this->employeModel->update($idEmploye, [
            'nb_permissions_restantes' => $employe['nb_permissions_restantes'] - 1
        ]);

        return redirect()->to('/absences')
            ->with('success', 'Permission ajoutée avec succès.');
    }

    private function restaurerConge($absence)
    {
        $nombreJours = $this->calculerJours(
            $absence['date_debut'],
            $absence['date_fin']
        );

        $employe = $this->employeModel->find($absence['id_employe']);

        if ($employe) {
            $nouveauQuota = min(
                15,
                $employe['nb_conges_restants'] + $nombreJours
            );

            $this->employeModel->update($absence['id_employe'], [
                'nb_conges_restants' => $nouveauQuota
            ]);
        }
    }

    private function restaurerPermission($absence)
    {
        $employe = $this->employeModel->find($absence['id_employe']);

        if ($employe) {
            $nouveauQuota = min(
                3,
                $employe['nb_permissions_restantes'] + 1
            );

            $this->employeModel->update($absence['id_employe'], [
                'nb_permissions_restantes' => $nouveauQuota
            ]);
        }
    }

    private function modifierQuotaConge($idEmploye, $nouveauNombreJours)
    {
        $employe = $this->employeModel->find($idEmploye);

        if (!$employe || $employe['nb_conges_restants'] < $nouveauNombreJours) {
            throw new \RuntimeException(
                'Le nombre de jours de congé disponibles est insuffisant.'
            );
        }

        $this->employeModel->update($idEmploye, [
            'nb_conges_restants' => $employe['nb_conges_restants'] - $nouveauNombreJours
        ]);
    }

    private function modifierQuotaPermission($idEmploye, $nombreJours)
    {
        $employe = $this->employeModel->find($idEmploye);

        if (!$employe || $employe['nb_permissions_restantes'] <= 0) {
            throw new \RuntimeException(
                'Le nombre de permissions disponibles est insuffisant.'
            );
        }

        $this->employeModel->update($idEmploye, [
            'nb_permissions_restantes' => $employe['nb_permissions_restantes'] - 1
        ]);
    }
}