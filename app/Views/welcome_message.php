<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

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

        /* NAVBAR */

        .sidebar {
            width: 250px;
            background-color: #0d47a1;
            color: white;
            min-height: 100vh;
        }

        .logo {
            padding: 25px 20px;
            font-size: 21px;
            font-weight: bold;
            border-bottom: 1px solid rgba(255,255,255,0.2);
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

        .welcome {
            background-color: white;
            padding: 35px;
            border-radius: 10px;

            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        h1 {
            margin-top: 0;
            color: #333;
        }

        p {
            color: #666;
            font-size: 16px;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;

            padding: 11px 18px;

            background-color: #0d6efd;
            color: white;

            text-decoration: none;

            border-radius: 5px;
        }

        .btn:hover {
            background-color: #0b5ed7;
        }

    </style>

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
                Cette application permet de gérer les employés
                et leurs salaires.
            </p>

            <a
                href="<?= site_url('employees') ?>"
                class="btn"
            >
                Gestion des employés
            </a>

        </div>

    </main>

</div>

</body>

</html>