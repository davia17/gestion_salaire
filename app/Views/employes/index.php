<?php
/**
 * @var array $employes
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

    <title>Gestion des employés</title>

    <link rel="stylesheet" href="<?= base_url('style.css') ?>">

</head>

<body>

<div class="layout">

    <?= view('layouts/navbar') ?>

    <main class="content">

        <div class="page-header">

            <h1>Gestion des employés</h1>

            <a
                href="<?= site_url('employes/new') ?>"
                class="btn btn-primary"
            >
                + Ajouter un employé
            </a>

        </div>

        <?php if (empty($employes)): ?>

            <div class="card">
                <p>Aucun employé enregistré.</p>
            </div>

        <?php else: ?>

            <div class="card">

                <table class="table">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Date de naissance</th>
                            <th>Date d'embauche</th>
                            <th>Poste</th>
                            <th>Salaire de base</th>
                            <th>Congés restants</th>
                            <th>Permissions restantes</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach ($employes as $employe): ?>

                        <tr>

                            <td>
                                <?= esc($employe['id_employe']) ?>
                            </td>

                            <td>
                                <?= esc($employe['nom']) ?>
                            </td>

                            <td>
                                <?= esc($employe['prenom']) ?>
                            </td>

                            <td>
                                <?= esc($employe['date_naissance']) ?>
                            </td>

                            <td>
                                <?= esc($employe['date_embauche']) ?>
                            </td>

                            <td>
                                <?= esc($employe['poste']) ?>
                            </td>

                            <td>
                                <?= number_format(
                                    (float) $employe['salaire_base_personnalise'],
                                    2,
                                    ',',
                                    ' '
                                ) ?> Ar
                            </td>

                            <td>
                                <?= esc($employe['nb_conges_restants']) ?> jours
                            </td>

                            <td>
                                <?= esc($employe['nb_permissions_restantes']) ?>
                            </td>

                            <td>

                                <a
                                    href="<?= site_url('employes/edit/' . $employe['id_employe']) ?>"
                                    class="btn btn-warning"
                                >
                                    Modifier
                                </a>

                                <a
                                    href="<?= site_url('employes/delete/' . $employe['id_employe']) ?>"
                                    class="btn btn-danger"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cet employé ?');"
                                >
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