<?php

/**
 * @var array|null $prime
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
                                    <?= ($prime['id_employe'] ?? '') == $employe['id_employe'] ? 'selected' : '' ?>>
                                    <?= esc($employe['nom'] . ' ' . $employe['prenom']) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="form-group">

                        <label for="libelle">
                            Libellé de la prime
                        </label>

                        <input
                            type="text"
                            id="libelle"
                            name="libelle"
                            class="form-control"
                            value="<?= esc($prime['libelle'] ?? '') ?>"
                            placeholder="Ex : Prime exceptionnelle"
                            required>

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
                            value="<?= esc($prime['montant'] ?? '') ?>"
                            placeholder="Ex : 150000"
                            min="0"
                            step="0.01"
                            required>

                    </div>

                    <div class="form-group">

                        <label for="date_prime">
                            Date de la prime
                        </label>

                        <input
                            type="date"
                            id="date_prime"
                            name="date_prime"
                            class="form-control"
                            value="<?= esc($prime['date_prime'] ?? '') ?>"
                            required>

                    </div>

                    <div class="form-actions">

                        <button
                            type="submit"
                            class="btn btn-primary">
                            Enregistrer
                        </button>

                        <a
                            href="<?= site_url('primes') ?>"
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