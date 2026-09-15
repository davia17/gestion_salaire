<?php
/**
 * @var array $postes
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

    <title>Gestion des postes</title>

    <link rel="stylesheet" href="<?= base_url('style.css') ?>">

</head>

<body>

<div class="layout">

    <?= view('layouts/navbar') ?>

    <main class="content">

        <div class="page-header">

            <h1>Gestion des postes</h1>

            <a
                href="<?= site_url('postes/new') ?>"
                class="btn btn-primary"
            >
                + Ajouter un poste
            </a>

        </div>

        <?php if (empty($postes)): ?>

            <div class="card">
                <p>Aucun poste enregistré.</p>
            </div>

        <?php else: ?>

            <div class="card">

                <table class="table">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Libellé</th>
                            <th>Salaire de base</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach ($postes as $poste): ?>

                        <tr>

                            <td>
                                <?= esc($poste['id_poste']) ?>
                            </td>

                            <td>
                                <?= esc($poste['libelle']) ?>
                            </td>

                            <td>
                                <?= number_format(
                                    (float) $poste['salaire_base_poste'],
                                    2,
                                    ',',
                                    ' '
                                ) ?> Ar
                            </td>

                            <td>

                                <a
                                    href="<?= site_url('postes/edit/' . $poste['id_poste']) ?>"
                                    class="btn btn-warning"
                                >
                                    Modifier
                                </a>

                                <a
                                    href="<?= site_url('postes/delete/' . $poste['id_poste']) ?>"
                                    class="btn btn-danger"
                                    onclick="return confirm('Voulez-vous vraiment supprimer ce poste ?');"
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