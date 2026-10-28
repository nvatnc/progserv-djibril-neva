<?php
const DATABASE_CONFIGURATION_FILE = __DIR__ . '/../config/database.ini';

// Lecture du fichier de configuration
// Documentation : https://www.php.net/manual/fr/function.parse-ini-file.php
$config = parse_ini_file(DATABASE_CONFIGURATION_FILE, true);

if (!$config) {
    throw new Exception("Erreur lors de la lecture du fichier de configuration : " . DATABASE_CONFIGURATION_FILE);
}

$host = $config['host'];
$port = $config['port'];
$database = $config['database'];
$username = $config['username'];
$password = $config['password'];

// Connexion à la base de données
$pdo = new PDO(
    "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4",
    $username,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasty Home</title>

    <!-- Police Inter (comme sur la maquette) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <!-- En-tête commun à toutes les pages -->
    <header class="entete">
        <a href="/" class="entete-logo">Tasty Home</a>

        <nav class="entete-menu">
            <a href="/plats.php">Plats</a>
            <a href="/profil.php">Mon profil</a>
            <a href="/connexion.php">Connexion</a>
        </nav>
    </header>

    <main class="accueil">

        <!-- Colonne de gauche : texte -->
        <section class="accueil-texte">
            <p class="sur-titre">HEIG-VD · EPFL · UNIL</p>

            <h1 class="accueil-titre">
                Cuisine<br>
                <span class="rouge">Donne</span><br>
                Partage
            </h1>

            <hr class="separateur">

            <p class="accueil-intro">
                L'entraide alimentaire entre étudiant·e·s<br>
                des hautes écoles vaudoises. Gratuit.<br>
                Fait maison. Entre pairs.
            </p>

            <div class="boutons">
                <a href="/plats.php" class="bouton bouton-plein">Je veux un plat</a>
                <a href="/plat-ajout.php" class="bouton bouton-contour">Je donne un plat</a>
            </div>
        </section>

        <!-- Colonne de droite : photo -->
        <div class="accueil-photo">
            <img src="/assets/img/src/public/assets/img/tommao-wang-tWiqmA9D-v4-unsplash.jpg" alt="Salade de légumes frais">
        </div>

    </main>

</body>

</html>
