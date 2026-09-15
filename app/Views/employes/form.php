<?php
/**
 * @var array|null $employe
 * @var array $postes
 * @var string $action
 * @var string $title
 */
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title) ?></title>

    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>

<body>

<div class="container">

    <h1><?= esc($title) ?></h1>

    <div class="card">

        <form action="<?= site_url($action) ?>" method="post">

            <!-- ID EMPLOYÉ -->
            <div class="form-group">
                <label for="id_employe">ID employé</label>

                <input
                    type="text"
                    id="id_employe"
                    name="id_employe"
                    class="form-control"
                    value="<?= esc($employe['id_employe'] ?? '') ?>"
                    placeholder="Ex : EMP001"
                    <?= $employe !== null ? 'readonly' : '' ?>
                    required
                >
            </div>

            <!-- NOM -->
            <div class="form-group">
                <label for="nom">Nom</label>

                <input
                    type="text"
                    id="nom"
                    name="nom"
                    class="form-control"
                    value="<?= esc($employe['nom'] ?? '') ?>"
                    placeholder="Ex : RAKOTO"
                    required
                >
            </div>

            <!-- PRÉNOM -->
            <div class="form-group">
                <label for="prenom">Prénom</label>

                <input
                    type="text"
                    id="prenom"
                    name="prenom"
                    class="form-control"
                    value="<?= esc($employe['prenom'] ?? '') ?>"
                    placeholder="Ex : Jean"
                    required
                >
            </div>

            <!-- DATE DE NAISSANCE -->
            <div class="form-group">
                <label for="date_naissance">Date de naissance</label>

                <input
                    type="date"
                    id="date_naissance"
                    name="date_naissance"
                    class="form-control"
                    value="<?= esc($employe['date_naissance'] ?? '') ?>"
                    required
                >
            </div>

            <!-- DATE D'EMBAUCHE -->
            <div class="form-group">
                <label for="date_embauche">Date d'embauche</label>

                <input
                    type="date"
                    id="date_embauche"
                    name="date_embauche"
                    class="form-control"
                    value="<?= esc($employe['date_embauche'] ?? '') ?>"
                    required
                >
            </div>

            <!-- POSTE -->
            <div class="form-group">
                <label for="id_poste">Poste</label>

                <select
                    id="id_poste"
                    name="id_poste"
                    class="form-control"
                    required
                >

                    <option value="">-- Sélectionner un poste --</option>

                    <?php foreach ($postes as $poste): ?>

                        <option
                            value="<?= esc($poste['id_poste']) ?>"
                            <?= isset($employe['id_poste']) &&
                                $employe['id_poste'] == $poste['id_poste']
                                ? 'selected'
                                : '' ?>
                        >
                            <?= esc($poste['libelle']) ?>
                            -
                            <?= number_format(
                                (float) $poste['salaire_base_poste'],
                                2,
                                ',',
                                ' '
                            ) ?> Ar
                        </option>

                    <?php endforeach; ?>

                </select>
            </div>

            <!-- SALAIRE DE BASE PERSONNALISÉ -->
            <div class="form-group">
                <label for="salaire_base_personnalise">
                    Salaire de base personnalisé
                </label>

                <input
                    type="number"
                    id="salaire_base_personnalise"
                    name="salaire_base_personnalise"
                    class="form-control"
                    value="<?= esc($employe['salaire_base_personnalise'] ?? '') ?>"
                    placeholder="Ex : 500000"
                    min="0"
                    step="0.01"
                    required
                >
            </div>

            <!-- BOUTONS -->
            <div style="margin-top: 20px;">

                <button type="submit" class="btn btn-primary">
                    Enregistrer
                </button>

                <a
                    href="<?= site_url('employes') ?>"
                    class="btn btn-danger"
                >
                    Annuler
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>
