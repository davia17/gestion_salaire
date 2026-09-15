<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Gestion de paie</title>

    <link rel="stylesheet" href="<?= base_url('style.css') ?>">

</head>

<body>

    <div class="layout">

        <?= view('layouts/navbar') ?>

        <main class="content">

            <div class="welcome">

                <h1>
                    Bienvenue dans l'application de gestion de paie
                </h1>

                <p>
                    Cette application permet de gérer les employés,
                    les postes et les salaires.
                </p>

                <a
                    href="<?= site_url('employes') ?>"
                    class="btn">
                    Gestion des employés
                </a>

            </div>

        </main>

    </div>

</body>

</html>