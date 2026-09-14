<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Gestion de paie</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f7fa;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #0d47a1;
            color: white;
        }

        .logo {
            padding: 25px 20px;
            font-size: 21px;
            font-weight: bold;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .menu {
            padding-top: 20px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;

            padding: 15px 20px;

            color: white;
            text-decoration: none;

            font-size: 15px;
        }

        .menu-item:hover {
            background-color: #1565c0;
        }

        /* CONTENU */

        .content {
            flex: 1;
            padding: 40px;
        }

        .container {
            max-width: 1200px;
            margin: auto;

            background-color: white;

            padding: 30px;

            border-radius: 10px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0;
            color: #333;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-add {
            background-color: #0d6efd;
            color: white;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #000;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #0d6efd;
            color: white;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #777;
        }

        .net {
            font-weight: bold;
        }
    </style>

</head>

<body>

    <div class="layout">

        <?= view('layouts/navbar') ?>

        <main class="content">

            <div class="container">

                <div class="header">

                    <h1>
                        Gestion de paie
                    </h1>

                    <a
                        href="<?= site_url('salaries/new') ?>"
                        class="btn btn-add">
                        + Ajouter un salaire
                    </a>

                </div>

                <?php if (!empty($salaries)): ?>

                    <table>

                        <thead>

                            <tr>
                                <th>ID</th>
                                <th>Employé</th>
                                <th>Mois</th>
                                <th>Année</th>
                                <th>Salaire de base</th>
                                <th>Prime</th>
                                <th>Retenue</th>
                                <th>Salaire net</th>
                                <th>Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($salaries as $salary): ?>

                                <tr>

                                    <td>
                                        <?= esc($salary['id']) ?>
                                    </td>

                                    <td>
                                        <?= esc($salary['prenom']) ?>
                                        <?= esc($salary['nom']) ?>
                                    </td>

                                    <td>
                                        <?= esc($salary['mois']) ?>
                                    </td>

                                    <td>
                                        <?= esc($salary['annee']) ?>
                                    </td>

                                    <td>
                                        <?= number_format(
                                            $salary['salaire_base'],
                                            2,
                                            ',',
                                            ' '
                                        ) ?> Ar
                                    </td>

                                    <td>
                                        <?= number_format(
                                            $salary['prime'],
                                            2,
                                            ',',
                                            ' '
                                        ) ?> Ar
                                    </td>

                                    <td>
                                        <?= number_format(
                                            $salary['retenue'],
                                            2,
                                            ',',
                                            ' '
                                        ) ?> Ar
                                    </td>

                                    <td class="net">
                                        <?= number_format(
                                            $salary['salaire_net'],
                                            2,
                                            ',',
                                            ' '
                                        ) ?> Ar
                                    </td>

                                    <td>

                                        <div class="actions">

                                            <a
                                                href="<?= site_url('salaries/edit/' . $salary['id']) ?>"
                                                class="btn btn-edit">
                                                Modifier
                                            </a>

                                            <a
                                                href="<?= site_url('salaries/delete/' . $salary['id']) ?>"
                                                class="btn btn-delete"
                                                onclick="return confirm('Voulez-vous vraiment supprimer ce salaire ?')">
                                                Supprimer
                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                <?php else: ?>

                    <div class="empty">
                        Aucun salaire enregistré.
                    </div>

                <?php endif; ?>

            </div>

        </main>

    </div>

</body>

</html>