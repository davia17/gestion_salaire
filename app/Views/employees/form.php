<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title) ?></title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f7fa;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 25px;
            color: #333;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #444;
        }

        input {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #0d6efd;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-save {
            background-color: #0d6efd;
            color: white;
        }

        .btn-cancel {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>

<body>

<div class="container">

    <h1><?= esc($title) ?></h1>

    <form action="<?= site_url($action) ?>" method="post">

        <?= csrf_field() ?>

        <div class="form-group">
            <label for="nom">Nom</label>

            <input
                type="text"
                id="nom"
                name="nom"
                value="<?= esc($employee['nom'] ?? '') ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>

            <input
                type="text"
                id="prenom"
                name="prenom"
                value="<?= esc($employee['prenom'] ?? '') ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="poste">Poste</label>

            <input
                type="text"
                id="poste"
                name="poste"
                value="<?= esc($employee['poste'] ?? '') ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="salaire_base">Salaire de base</label>

            <input
                type="number"
                id="salaire_base"
                name="salaire_base"
                step="0.01"
                min="0"
                value="<?= esc($employee['salaire_base'] ?? '') ?>"
                required
            >
        </div>

        <div class="buttons">

            <button type="submit" class="btn btn-save">
                Enregistrer
            </button>

            <a
                href="<?= site_url('employees') ?>"
                class="btn btn-cancel"
            >
                Annuler
            </a>

        </div>

    </form>

</div>

</body>
</html>