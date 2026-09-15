<?php

namespace App\Controllers;

use App\Models\PosteModel;

class PosteController extends BaseController
{
    protected $posteModel;

    public function __construct()
    {
        $this->posteModel = new PosteModel();
    }

    // READ - Afficher tous les postes
    public function index()
    {
        $data = [
            'postes' => $this->posteModel->findAll()
        ];

        return view('postes/index', $data);
    }

    // CREATE - Afficher le formulaire
    public function new()
    {
        $data = [
            'poste'  => null,
            'action' => '/postes/create',
            'title'  => 'Ajouter un poste'
        ];

        return view('postes/form', $data);
    }

    // CREATE - Enregistrer un poste
    public function create()
    {
        $data = [
            'libelle'            => $this->request->getPost('libelle'),
            'salaire_base_poste' => $this->request->getPost('salaire_base_poste')
        ];

        $this->posteModel->insert($data);

        return redirect()->to('/postes');
    }

    // UPDATE - Afficher le formulaire de modification
    public function edit($id)
    {
        $poste = $this->posteModel->find($id);

        if (!$poste) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Poste introuvable'
            );
        }

        $data = [
            'poste'  => $poste,
            'action' => '/postes/update/' . $id,
            'title'  => 'Modifier un poste'
        ];

        return view('postes/form', $data);
    }

    // UPDATE - Enregistrer les modifications
    public function update($id)
    {
        $data = [
            'libelle'            => $this->request->getPost('libelle'),
            'salaire_base_poste' => $this->request->getPost('salaire_base_poste')
        ];

        $this->posteModel->update($id, $data);

        return redirect()->to('/postes');
    }

    // DELETE - Supprimer un poste
    public function delete($id)
    {
        $this->posteModel->delete($id);

        return redirect()->to('/postes');
    }
}