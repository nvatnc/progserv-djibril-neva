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
$pdo = new PDO("mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4", $username, $password);

// Récupération de toutes les catégories
$sql = "SELECT * FROM categories";

$stmt = $pdo->prepare($sql);

$stmt->execute();

$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nom du site à définir</title>
</head>

<body>
    <h1>Nom du site à définir</h1>

    <p>Le site est en ligne et connecté à la base de données.</p>

    <h2>Catégories</h2>

    <ul>
        <?php foreach ($categories as $categorie) { ?>
            <li><?= htmlspecialchars($categorie['nom_de_la_categorie']) ?></li>
        <?php } ?>
    </ul>

    <footer>
        <p>Projet réalisé dans le cadre du cours ProgServ2 à la HEIG-VD.</p>
    </footer>
</body>

</html>
