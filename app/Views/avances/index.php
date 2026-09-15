<?php

/**
 * @var array $avances
 * @var array $employes
 * @var string|null $filtre_employe
 * @var string|null $filtre_motif
 */
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Gestion des avances</title>

    <link rel="stylesheet" href="<?= base_url('style.css') ?>">

</head>

<body>

    <div class="layout">

        <?= view('layouts/navbar') ?>

        <main class="content">

            <div class="page-header">

                <h1>Gestion des avances</h1>

                <a
                    href="<?= site_url('avances/new') ?>"
                    class="btn btn-primary">
                    + Ajouter une avance
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

                <form action="<?= site_url('avances') ?>" method="get">

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

                        <label for="motif">
                            Motif
                        </label>

                        <input
                            type="text"
                            id="motif"
                            name="motif"
                            class="form-control"
                            value="<?= esc($filtre_motif ?? '') ?>"
                            placeholder="Rechercher par motif">

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Rechercher
                    </button>

                    <a
                        href="<?= site_url('avances') ?>"
                        class="btn btn-danger">
                        Réinitialiser
                    </a>

                </form>

            </div>

            <?php if (empty($avances)): ?>

                <div class="card">
                    <p>Aucune avance enregistrée.</p>
                </div>

            <?php else: ?>

                <div class="card">

                    <table class="table">

                        <thead>

                            <tr>
                                <th>ID</th>
                                <th>Employé</th>
                                <th>Montant</th>
                                <th>Date</th>
                                <th>Motif</th>
                                <th>Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($avances as $avance): ?>

                                <tr>

                                    <td>
                                        <?= esc($avance['id_avance']) ?>
                                    </td>

                                    <td>
                                        <?= esc($avance['nom'] . ' ' . $avance['prenom']) ?>
                                    </td>

                                    <td>
                                        <?= number_format(
                                            (float) $avance['montant'],
                                            2,
                                            ',',
                                            ' '
                                        ) ?> Ar
                                    </td>

                                    <td>
                                        <?= esc($avance['date_avance']) ?>
                                    </td>

                                    <td>
                                        <?= esc($avance['motif']) ?>
                                    </td>

                                    <td>

                                        <a
                                            href="<?= site_url('avances/edit/' . $avance['id_avance']) ?>"
                                            class="btn btn-warning">
                                            Modifier
                                        </a>

                                        <a
                                            href="<?= site_url('avances/delete/' . $avance['id_avance']) ?>"
                                            class="btn btn-danger"
                                            onclick="return confirm('Voulez-vous vraiment supprimer cette avance ?');">
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