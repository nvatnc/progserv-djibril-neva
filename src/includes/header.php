<?php
// En-tête commun à toutes les pages.
// Avant de l'inclure, la page définit :
//     $titre      : le titre de l'onglet (ex. "Plats")
//     $pageActive : le lien du menu à souligner ("plats", "profil" ou "connexion")
$titre = $titre ?? 'Tasty Home';
$pageActive = $pageActive ?? '';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre) ?></title>

    <!-- Police Inter (comme sur la maquette) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">

    <!-- ?v=… change à chaque modification du CSS : le navigateur recharge alors la nouvelle version -->
    <link rel="stylesheet" href="/assets/css/style.css?v=<?= filemtime(__DIR__ . '/../public/assets/css/style.css') ?>">
</head>

<body>

    <header class="entete">
        <a href="/" class="entete-logo">Tasty Home</a>

        <nav class="entete-menu">
            <a href="/plats.php" class="<?= $pageActive === 'plats' ? 'actif' : '' ?>">Plats</a>
            <a href="/profil.php" class="<?= $pageActive === 'profil' ? 'actif' : '' ?>">Mon profil</a>
            <a href="/connexion.php" class="<?= $pageActive === 'connexion' ? 'actif' : '' ?>">Connexion</a>
        </nav>
    </header>
