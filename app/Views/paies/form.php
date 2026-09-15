<?php

/**
 * @var array|null $paie
 * @var array $employes
 * @var string $action
 * @var string $title
 */

$paie = $paie ?? null;
$employes = $employes ?? [];
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

            <div class="page-header">

                <h1><?= esc($title) ?></h1>

                <a
                    href="<?= site_url('paies') ?>"
                    class="btn">
                    Retour
                </a>

            </div>

            <?php if (session()->getFlashdata('error')): ?>

                <div class="alert alert-danger">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>

            <?php endif; ?>

            <div class="card">

                <form
                    action="<?= site_url(ltrim($action, '/')) ?>"
                    method="post">

                    <?= csrf_field() ?>

                    <div class="form-group">

                        <label for="id_employe">
                            Employé
                        </label>

                        <select
                            name="id_employe"
                            id="id_employe"
                            class="form-control"
                            required>

                            <option value="">
                                Sélectionner un employé
                            </option>

                            <?php foreach ($employes as $employe): ?>

                                <option
                                    value="<?= esc($employe['id_employe']) ?>"
                                    <?= $paie && $paie['id_employe'] == $employe['id_employe'] ? 'selected' : '' ?>>
                                    <?= esc($employe['nom']) ?>
                                    <?= esc($employe['prenom']) ?>
                                    -
                                    <?= number_format(
                                        (float) $employe['salaire_base_personnalise'],
                                        2,
                                        ',',
                                        ' '
                                    ) ?> Ar
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
                            class="form-control"
                            required>

                            <option value="">
                                Sélectionner un mois
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
                                    <?= $paie && $paie['mois'] == $numero ? 'selected' : '' ?>>
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
                            value="<?= $paie ? esc($paie['annee']) : date('Y') ?>"
                            min="2000"
                            max="2100"
                            required>

                    </div>

                    <div class="form-group">

                        <label for="date_paiement">
                            Date de paiement
                        </label>

                        <input
                            type="date"
                            name="date_paiement"
                            id="date_paiement"
                            class="form-control"
                            value="<?= $paie ? esc($paie['date_paiement']) : '' ?>">

                    </div>

                    <?php if ($paie): ?>

                        <div class="card">

                            <h2>Résumé du calcul</h2>

                            <p>
                                Salaire brut :
                                <strong>
                                    <?= number_format(
                                        (float) $paie['salaire_brut'],
                                        2,
                                        ',',
                                        ' '
                                    ) ?> Ar
                                </strong>
                            </p>

                            <p>
                                Total primes :
                                <strong>
                                    <?= number_format(
                                        (float) $paie['prime_totale'],
                                        2,
                                        ',',
                                        ' '
                                    ) ?> Ar
                                </strong>
                            </p>

                            <p>
                                Jours d'absence :
                                <strong>
                                    <?= esc($paie['absence_jours']) ?> jours
                                </strong>
                            </p>

                            <p>
                                Avances :
                                <strong>
                                    <?= number_format(
                                        (float) $paie['total_avances'],
                                        2,
                                        ',',
                                        ' '
                                    ) ?> Ar
                                </strong>
                            </p>

                            <p>
                                CNaPS :
                                <strong>
                                    <?= number_format(
                                        (float) $paie['deduction_cnap'],
                                        2,
                                        ',',
                                        ' '
                                    ) ?> Ar
                                </strong>
                            </p>

                            <p>
                                IRSA :
                                <strong>
                                    <?= number_format(
                                        (float) $paie['deduction_irsa'],
                                        2,
                                        ',',
                                        ' '
                                    ) ?> Ar
                                </strong>
                            </p>

                            <p>
                                Salaire net :
                                <strong>
                                    <?= number_format(
                                        (float) $paie['salaire_net'],
                                        2,
                                        ',',
                                        ' '
                                    ) ?> Ar
                                </strong>
                            </p>

                        </div>

                    <?php endif; ?>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        <?= $paie ? 'Recalculer la paie' : 'Calculer la paie' ?>
                    </button>

                    <a
                        href="<?= site_url('paies') ?>"
                        class="btn">
                        Annuler
                    </a>

                </form>

            </div>

        </main>

    </div>

</body>

</html>