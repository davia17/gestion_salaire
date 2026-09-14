<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des employés</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f7fa;
        }

        .container {
            max-width: 1100px;
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
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>Gestion des employés</h1>

        <a href="<?= site_url('employees/new') ?>" class="btn btn-add">
            + Ajouter un employé
        </a>
    </div>

    <?php if (!empty($employees)): ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Poste</th>
                    <th>Salaire de base</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($employees as $employee): ?>

                    <tr>
                        <td><?= esc($employee['id']) ?></td>

                        <td><?= esc($employee['nom']) ?></td>

                        <td><?= esc($employee['prenom']) ?></td>

                        <td><?= esc($employee['poste']) ?></td>

                        <td>
                            <?= number_format($employee['salaire_base'], 2, ',', ' ') ?> Ar
                        </td>

                        <td>
                            <div class="actions">

                                <a
                                    href="<?= site_url('employees/edit/' . $employee['id']) ?>"
                                    class="btn btn-edit"
                                >
                                    Modifier
                                </a>

                                <a
                                    href="<?= site_url('employees/delete/' . $employee['id']) ?>"
                                    class="btn btn-delete"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cet employé ?')"
                                >
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
            Aucun employé enregistré.
        </div>

    <?php endif; ?>

</div>

</body>
</html>