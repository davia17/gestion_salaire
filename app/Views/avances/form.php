<?php

/**
 * @var array|null $avance
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
        content="width=device-width, initial-scale=1.0">

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
                    method="post">

                    <div class="form-group">

                        <label for="id_employe">
                            Employé
                        </label>

                        <select
                            id="id_employe"
                            name="id_employe"
                            class="form-control"
                            required>

                            <option value="">
                                Sélectionner un employé
                            </option>

                            <?php foreach ($employes as $employe): ?>

                                <option
                                    value="<?= esc($employe['id_employe']) ?>"
                                    <?= ($avance['id_employe'] ?? '') == $employe['id_employe'] ? 'selected' : '' ?>>
                                    <?= esc($employe['nom'] . ' ' . $employe['prenom']) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="form-group">

                        <label for="montant">
                            Montant
                        </label>

                        <input
                            type="number"
                            id="montant"
                            name="montant"
                            class="form-control"
                            value="<?= esc($avance['montant'] ?? '') ?>"
                            placeholder="Ex : 200000"
                            min="0"
                            step="0.01"
                            required>

                    </div>

                    <div class="form-group">

                        <label for="date_avance">
                            Date de l'avance
                        </label>

                        <input
                            type="date"
                            id="date_avance"
                            name="date_avance"
                            class="form-control"
                            value="<?= esc($avance['date_avance'] ?? '') ?>"
                            required>

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
                            value="<?= esc($avance['motif'] ?? '') ?>"
                            placeholder="Ex : Besoin personnel"
                            required>

                    </div>

                    <div class="form-actions">

                        <button
                            type="submit"
                            class="btn btn-primary">
                            Enregistrer
                        </button>

                        <a
                            href="<?= site_url('avances') ?>"
                            class="btn btn-danger">
                            Annuler
                        </a>

                    </div>

                </form>

            </div>

        </main>

    </div>

</body>

</html>