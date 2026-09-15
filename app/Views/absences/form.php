<?php
/**
 * @var array|null $absence
 * @var array $employes
 * @var string $action
 * @var string $title
 */
?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title><?= esc($title) ?></title>

    <link rel="stylesheet" href="<?= base_url('style.css') ?>">

</head>

<body>

<div class="layout">

    <?= view('layouts/navbar') ?>

    <main class="content">

        <h1><?= esc($title) ?></h1>

        <div class="card">

            <?php if (session()->getFlashdata('error')): ?>

                <div class="alert alert-danger">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>

            <?php endif; ?>

            <form
                action="<?= site_url($action) ?>"
                method="post"
            >

                <div class="form-group">

                    <label for="id_employe">
                        Employé
                    </label>

                    <select
                        id="id_employe"
                        name="id_employe"
                        class="form-control"
                        required
                    >

                        <option value="">
                            Sélectionner un employé
                        </option>

                        <?php foreach ($employes as $employe): ?>

                            <option
                                value="<?= esc($employe['id_employe']) ?>"
                                <?= ($absence['id_employe'] ?? '') == $employe['id_employe'] ? 'selected' : '' ?>
                            >
                                <?= esc($employe['nom'] . ' ' . $employe['prenom']) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="form-group">

                    <label for="type">
                        Type
                    </label>

                    <select
                        id="type"
                        name="type"
                        class="form-control"
                        required
                    >

                        <option value="">
                            Sélectionner un type
                        </option>

                        <option
                            value="Congé"
                            <?= ($absence['type'] ?? '') === 'Congé' ? 'selected' : '' ?>
                        >
                            Congé
                        </option>

                        <option
                            value="Permission"
                            <?= ($absence['type'] ?? '') === 'Permission' ? 'selected' : '' ?>
                        >
                            Permission
                        </option>

                        <option
                            value="Absence"
                            <?= ($absence['type'] ?? '') === 'Absence' ? 'selected' : '' ?>
                        >
                            Absence
                        </option>

                    </select>

                </div>

                <div class="form-group">

                    <label for="date_debut">
                        Date de début
                    </label>

                    <input
                        type="date"
                        id="date_debut"
                        name="date_debut"
                        class="form-control"
                        value="<?= esc($absence['date_debut'] ?? '') ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="date_fin">
                        Date de fin
                    </label>

                    <input
                        type="date"
                        id="date_fin"
                        name="date_fin"
                        class="form-control"
                        value="<?= esc($absence['date_fin'] ?? '') ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="motif">
                        Motif
                    </label>

                    <input
                        type="text"
                        id="motif"
                        name="motif"
                        class="form-control"
                        value="<?= esc($absence['motif'] ?? '') ?>"
                        placeholder="Ex : Vacances, raison personnelle..."
                        required
                    >

                </div>

                <div class="form-actions">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Enregistrer
                    </button>

                    <a
                        href="<?= site_url('absences') ?>"
                        class="btn btn-danger"
                    >
                        Annuler
                    </a>

                </div>

            </form>

        </div>

    </main>

</div>

</body>

</html>