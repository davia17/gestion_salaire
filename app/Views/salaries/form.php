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

        input,
        select {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
        }

        input:focus,
        select:focus {
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

        .net {
            background-color: #e9f7ef;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container">

        <h1><?= esc($title) ?></h1>

        <form action="<?= site_url($action) ?>" method="post">

            <?= csrf_field() ?>

            <!-- Employé -->
            <div class="form-group">

                <label for="employee_id">
                    Employé
                </label>

                <select
                    id="employee_id"
                    name="employee_id"
                    required>

                    <option value="">
                        -- Sélectionner un employé --
                    </option>

                    <?php foreach ($employees as $employee): ?>

                        <option
                            value="<?= esc($employee['id']) ?>"
                            <?= isset($salary['employee_id']) &&
                                $salary['employee_id'] == $employee['id']
                                ? 'selected'
                                : '' ?>>
                            <?= esc($employee['prenom']) ?>
                            <?= esc($employee['nom']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <!-- Mois -->
            <div class="form-group">

                <label for="mois">
                    Mois
                </label>

                <select
                    id="mois"
                    name="mois"
                    required>

                    <option value="">
                        -- Sélectionner un mois --
                    </option>

                    <?php
                    $moisListe = [
                        1  => 'Janvier',
                        2  => 'Février',
                        3  => 'Mars',
                        4  => 'Avril',
                        5  => 'Mai',
                        6  => 'Juin',
                        7  => 'Juillet',
                        8  => 'Août',
                        9  => 'Septembre',
                        10 => 'Octobre',
                        11 => 'Novembre',
                        12 => 'Décembre'
                    ];
                    ?>

                    <?php foreach ($moisListe as $numero => $nomMois): ?>

                        <option
                            value="<?= $numero ?>"
                            <?= isset($salary['mois']) &&
                                $salary['mois'] == $numero
                                ? 'selected'
                                : '' ?>>
                            <?= $nomMois ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <!-- Année -->
            <div class="form-group">

                <label for="annee">
                    Année
                </label>

                <input
                    type="number"
                    id="annee"
                    name="annee"
                    min="2000"
                    max="2100"
                    value="<?= esc($salary['annee'] ?? date('Y')) ?>"
                    required>

            </div>


            <!-- Salaire de base -->
            <div class="form-group">

                <label for="salaire_base">
                    Salaire de base
                </label>

                <input
                    type="number"
                    id="salaire_base"
                    name="salaire_base"
                    step="0.01"
                    min="0"
                    value="<?= esc($salary['salaire_base'] ?? '') ?>"
                    required>

            </div>


            <!-- Prime -->
            <div class="form-group">

                <label for="prime">
                    Prime
                </label>

                <input
                    type="number"
                    id="prime"
                    name="prime"
                    step="0.01"
                    min="0"
                    value="<?= esc($salary['prime'] ?? '0') ?>">

            </div>


            <!-- Retenue -->
            <div class="form-group">

                <label for="retenue">
                    Retenue
                </label>

                <input
                    type="number"
                    id="retenue"
                    name="retenue"
                    step="0.01"
                    min="0"
                    value="<?= esc($salary['retenue'] ?? '0') ?>">

            </div>


            <!-- Salaire net -->
            <div class="form-group">

                <label for="salaire_net">
                    Salaire net
                </label>

                <input
                    type="number"
                    id="salaire_net"
                    name="salaire_net"
                    class="net"
                    step="0.01"
                    readonly
                    value="<?= esc($salary['salaire_net'] ?? '') ?>">

            </div>


            <div class="buttons">

                <button
                    type="submit"
                    class="btn btn-save">
                    Enregistrer
                </button>

                <a
                    href="<?= site_url('salaries') ?>"
                    class="btn btn-cancel">
                    Annuler
                </a>

            </div>

        </form>

    </div>


    <script>
        function calculerSalaireNet() {

            const salaireBase =
                parseFloat(document.getElementById('salaire_base').value) || 0;

            const prime =
                parseFloat(document.getElementById('prime').value) || 0;

            const retenue =
                parseFloat(document.getElementById('retenue').value) || 0;

            const salaireNet =
                salaireBase + prime - retenue;

            document.getElementById('salaire_net').value =
                salaireNet.toFixed(2);
        }


        document
            .getElementById('salaire_base')
            .addEventListener('input', calculerSalaireNet);

        document
            .getElementById('prime')
            .addEventListener('input', calculerSalaireNet);

        document
            .getElementById('retenue')
            .addEventListener('input', calculerSalaireNet);
    </script>

</body>

</html>