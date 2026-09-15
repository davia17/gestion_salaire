<?php

/**
 * @var array $primes
 * @var array $employes
 * @var string|null $filtre_employe
 * @var string|null $filtre_libelle
 */
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Gestion des primes</title>

    <link rel="stylesheet" href="<?= base_url('style.css') ?>">

</head>

<body>

    <div class="layout">

        <?= view('layouts/navbar') ?>

        <main class="content">

            <div class="page-header">

                <h1>Gestion des primes</h1>

                <a
                    href="<?= site_url('primes/new') ?>"
                    class="btn btn-primary">
                    + Ajouter une prime
                </a>

            </div>

            <?php if (session()->getFlashdata('success')): ?>

                <div class="alert alert-success">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>

            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>

                <div class="alert alert-danger">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>

            <?php endif; ?>

            <div class="card">

                <form action="<?= site_url('primes') ?>" method="get">

                    <div class="form-group">

                        <label for="id_employe">
                            Employé
                        </label>

                        <select
                            id="id_employe"
                            name="id_employe"
                            class="form-control">

                            <option value="">
                                Tous les employés
                            </option>

                            <?php foreach ($employes as $employe): ?>

                                <option
                                    value="<?= esc($employe['id_employe']) ?>"
                                    <?= $filtre_employe == $employe['id_employe'] ? 'selected' : '' ?>>
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
                            value="<?= esc($filtre_libelle ?? '') ?>"
                            placeholder="Rechercher une prime">

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Rechercher
                    </button>

                    <a
                        href="<?= site_url('primes') ?>"
                        class="btn btn-danger">
                        Réinitialiser
                    </a>

                </form>

            </div>

            <?php if (empty($primes)): ?>

                <div class="card">
                    <p>Aucune prime enregistrée.</p>
                </div>

            <?php else: ?>

                <div class="card">

                    <table class="table">

                        <thead>

                            <tr>
                                <th>ID</th>
                                <th>Employé</th>
                                <th>Libellé</th>
                                <th>Montant</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($primes as $prime): ?>

                                <tr>

                                    <td>
                                        <?= esc($prime['id_prime']) ?>
                                    </td>

                                    <td>
                                        <?= esc($prime['nom'] . ' ' . $prime['prenom']) ?>
                                    </td>

                                    <td>
                                        <?= esc($prime['libelle']) ?>
                                    </td>

                                    <td>
                                        <?= number_format(
                                            (float) $prime['montant'],
                                            2,
                                            ',',
                                            ' '
                                        ) ?> Ar
                                    </td>

                                    <td>
                                        <?= esc($prime['date_prime']) ?>
                                    </td>

                                    <td>

                                        <a
                                            href="<?= site_url('primes/edit/' . $prime['id_prime']) ?>"
                                            class="btn btn-warning">
                                            Modifier
                                        </a>

                                        <a
                                            href="<?= site_url('primes/delete/' . $prime['id_prime']) ?>"
                                            class="btn btn-danger"
                                            onclick="return confirm('Voulez-vous vraiment supprimer cette prime ?');">
                                            Supprimer
                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

        </main>

    </div>

</body>

</html>