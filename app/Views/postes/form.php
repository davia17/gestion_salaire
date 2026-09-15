<?php

/**
 * @var array|null $poste
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

                <form
                    action="<?= site_url($action) ?>"
                    method="post">

                    <div class="form-group">

                        <label for="libelle">
                            Libellé du poste
                        </label>

                        <input
                            type="text"
                            id="libelle"
                            name="libelle"
                            class="form-control"
                            value="<?= esc($poste['libelle'] ?? '') ?>"
                            placeholder="Ex : Développeur"
                            required>

                    </div>

                    <div class="form-group">

                        <label for="salaire_base_poste">
                            Salaire de base
                        </label>

                        <input
                            type="number"
                            id="salaire_base_poste"
                            name="salaire_base_poste"
                            class="form-control"
                            value="<?= esc($poste['salaire_base_poste'] ?? '') ?>"
                            placeholder="Ex : 800000"
                            min="0"
                            step="0.01"
                            required>

                    </div>

                    <div class="form-actions">

                        <button
                            type="submit"
                            class="btn btn-primary">
                            Enregistrer
                        </button>

                        <a
                            href="<?= site_url('postes') ?>"
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