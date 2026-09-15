<?php
/**
 * @var array $absences
 * @var array $employes
 * @var string|null $filtre_employe
 * @var string|null $filtre_type
 */
?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Absences et congés</title>

    <link rel="stylesheet" href="<?= base_url('style.css') ?>">

</head>

<body>

    <div class="layout">

        <?= view('layouts/navbar') ?>

        <main class="content">

            <div class="page-header">

                <h1>Absences et congés</h1>

                <a
                    href="<?= site_url('absences/new') ?>"
                    class="btn btn-primary">
                    + Ajouter
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

                <form
                    action="<?= site_url('absences') ?>"
                    method="get">

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
                                    <?= ($filtre_employe ?? '') == $employe['id_employe'] ? 'selected' : '' ?>>
                                    <?= esc($employe['nom'] . ' ' . $employe['prenom']) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="form-group">

                        <label for="type">
                            Type
                        </label>

                        <select
                            id="type"
                            name="type"
                            class="form-control">

                            <option value="">
                                Tous les types
                            </option>

                            <option
                                value="Congé"
                                <?= ($filtre_type ?? '') === 'Congé' ? 'selected' : '' ?>>
                                Congé
                            </option>

                            <option
                                value="Permission"
                                <?= ($filtre_type ?? '') === 'Permission' ? 'selected' : '' ?>>
                                Permission
                            </option>

                            <option
                                value="Absence"
                                <?= ($filtre_type ?? '') === 'Absence' ? 'selected' : '' ?>>
                                Absence
                            </option>

                        </select>

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Rechercher
                    </button>

                    <a
                        href="<?= site_url('absences') ?>"
                        class="btn btn-danger">
                        Réinitialiser
                    </a>

                </form>

            </div>

            <?php if (empty($absences)): ?>

                <div class="card">

                    <p>
                        Aucune absence, congé ou permission enregistré.
                    </p>

                </div>

            <?php else: ?>

                <div class="card">

                    <table class="table">

                        <thead>

                            <tr>
                                <th>ID</th>
                                <th>Employé</th>
                                <th>Type</th>
                                <th>Date début</th>
                                <th>Date fin</th>
                                <th>Nombre de jours</th>
                                <th>Motif</th>
                                <th>Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($absences as $absence): ?>

                                <?php
                                $debut = new DateTime($absence['date_debut']);
                                $fin = new DateTime($absence['date_fin']);
                                $nombreJours = $debut->diff($fin)->days + 1;
                                ?>

                                <tr>

                                    <td>
                                        <?= esc($absence['id_absence']) ?>
                                    </td>

                                    <td>
                                        <?= esc($absence['nom'] . ' ' . $absence['prenom']) ?>
                                    </td>

                                    <td>
                                        <?= esc($absence['type']) ?>
                                    </td>

                                    <td>
                                        <?= esc($absence['date_debut']) ?>
                                    </td>

                                    <td>
                                        <?= esc($absence['date_fin']) ?>
                                    </td>

                                    <td>
                                        <?= esc($nombreJours) ?> jour(s)
                                    </td>

                                    <td>
                                        <?= esc($absence['motif'] ?? '') ?>
                                    </td>

                                    <td>

                                        <a
                                            href="<?= site_url('absences/edit/' . $absence['id_absence']) ?>"
                                            class="btn btn-warning">
                                            Modifier
                                        </a>

                                        <a
                                            href="<?= site_url('absences/delete/' . $absence['id_absence']) ?>"
                                            class="btn btn-danger"
                                            onclick="return confirm('Voulez-vous vraiment supprimer cette absence ?');">
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