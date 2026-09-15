<?php

/**
 * @var array $paies
 * @var array $employes
 * @var string|null $filtre_employe
 * @var string|null $filtre_mois
 * @var string|null $filtre_annee
 */

$paies = $paies ?? [];
$employes = $employes ?? [];
$filtre_employe = $filtre_employe ?? '';
$filtre_mois = $filtre_mois ?? '';
$filtre_annee = $filtre_annee ?? '';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de paie</title>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>

<body>

    <div class="layout">

        <?= view('layouts/navbar') ?>

        <main class="content">

            <div class="page-header">

                <h1>Gestion de paie</h1>

                <a href="<?= site_url('paies/new') ?>" class="btn btn-primary">
                    + Calculer une paie
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

                <h2>Rechercher une paie</h2>

                <form method="get" action="<?= site_url('paies') ?>">

                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">

                        <div class="form-group">

                            <label for="id_employe">
                                Employé
                            </label>

                            <select
                                name="id_employe"
                                id="id_employe"
                                class="form-control">

                                <option value="">
                                    Tous les employés
                                </option>

                                <?php foreach ($employes as $employe): ?>

                                    <option
                                        value="<?= esc($employe['id_employe']) ?>"
                                        <?= $filtre_employe == $employe['id_employe'] ? 'selected' : '' ?>>
                                        <?= esc($employe['nom']) ?>
                                        <?= esc($employe['prenom']) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="form-group">

                            <label for="mois">
                                Mois
                            </label>

                            <select
                                name="mois"
                                id="mois"
                                class="form-control">

                                <option value="">
                                    Tous les mois
                                </option>

                                <?php
                                $moisNoms = [
                                    1 => 'Janvier',
                                    2 => 'Février',
                                    3 => 'Mars',
                                    4 => 'Avril',
                                    5 => 'Mai',
                                    6 => 'Juin',
                                    7 => 'Juillet',
                                    8 => 'Août',
                                    9 => 'Septembre',
                                    10 => 'Octobre',
                                    11 => 'Novembre',
                                    12 => 'Décembre'
                                ];
                                ?>

                                <?php foreach ($moisNoms as $numero => $nom): ?>

                                    <option
                                        value="<?= $numero ?>"
                                        <?= $filtre_mois == $numero ? 'selected' : '' ?>>
                                        <?= $nom ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="form-group">

                            <label for="annee">
                                Année
                            </label>

                            <input
                                type="number"
                                name="annee"
                                id="annee"
                                class="form-control"
                                value="<?= esc($filtre_annee) ?>"
                                placeholder="Ex : 2026">

                        </div>

                        <div class="form-group" style="display: flex; align-items: end; gap: 10px;">

                            <button type="submit" class="btn btn-primary">
                                Rechercher
                            </button>

                            <a href="<?= site_url('paies') ?>" class="btn">
                                Réinitialiser
                            </a>

                        </div>

                    </div>

                </form>

            </div>

            <?php if (empty($paies)): ?>

                <div class="card">

                    <p>
                        Aucune paie enregistrée.
                    </p>

                </div>

            <?php else: ?>

                <div class="card">

                    <table class="table">

                        <thead>

                            <tr>
                                <th>Employé</th>
                                <th>Période</th>
                                <th>Salaire brut</th>
                                <th>Primes</th>
                                <th>Absences</th>
                                <th>Avances</th>
                                <th>CNaPS</th>
                                <th>IRSA</th>
                                <th>Salaire net</th>
                                <th>Date paiement</th>
                                <th>Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($paies as $paie): ?>

                                <tr>

                                    <td>
                                        <?= esc($paie['nom']) ?>
                                        <?= esc($paie['prenom']) ?>
                                    </td>

                                    <td>
                                        <?= esc($paie['mois']) ?>/<?= esc($paie['annee']) ?>
                                    </td>

                                    <td>
                                        <?= number_format(
                                            (float) $paie['salaire_brut'],
                                            2,
                                            ',',
                                            ' '
                                        ) ?> Ar
                                    </td>

                                    <td>
                                        <?= number_format(
                                            (float) $paie['prime_totale'],
                                            2,
                                            ',',
                                            ' '
                                        ) ?> Ar
                                    </td>

                                    <td>
                                        <?= esc($paie['absence_jours']) ?> jours
                                    </td>

                                    <td>
                                        <?= number_format(
                                            (float) $paie['total_avances'],
                                            2,
                                            ',',
                                            ' '
                                        ) ?> Ar
                                    </td>

                                    <td>
                                        <?= number_format(
                                            (float) $paie['deduction_cnap'],
                                            2,
                                            ',',
                                            ' '
                                        ) ?> Ar
                                    </td>

                                    <td>
                                        <?= number_format(
                                            (float) $paie['deduction_irsa'],
                                            2,
                                            ',',
                                            ' '
                                        ) ?> Ar
                                    </td>

                                    <td>
                                        <strong>
                                            <?= number_format(
                                                (float) $paie['salaire_net'],
                                                2,
                                                ',',
                                                ' '
                                            ) ?> Ar
                                        </strong>
                                    </td>

                                    <td>
                                        <?= !empty($paie['date_paiement'])
                                            ? esc($paie['date_paiement'])
                                            : '-' ?>
                                    </td>

                                    <td>

                                        <a
                                            href="<?= site_url('paies/edit/' . $paie['id_paie']) ?>"
                                            class="btn btn-warning">
                                            Modifier
                                        </a>

                                        <a
                                            href="<?= site_url('paies/delete/' . $paie['id_paie']) ?>"
                                            class="btn btn-danger"
                                            onclick="return confirm('Voulez-vous vraiment supprimer cette paie ?');">
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