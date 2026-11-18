<?php
require __DIR__ . '/../includes/bootstrap.php';

$ecoleManager = new EcoleManager();
$utilisateurManager = new UtilisateurManager();
$ecoles = $ecoleManager->trouverToutes();

// Seules les adresses e-mail de ces écoles sont acceptées
$domainesAutorises = ["heig-vd.ch", "epfl.ch", "unil.ch"];

// Valeurs du formulaire (vides au départ)
$prenom = "";
$nom = "";
$email = "";
$telephone = "";
$idEcole = 0;

$erreurs = [];
$compteCree = false;

// Gère la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // On récupère les données du formulaire
    $prenom = trim($_POST["prenom"]);
    $nom = trim($_POST["nom"]);
    $email = trim($_POST["email"]);
    $telephone = trim($_POST["telephone"]);
    $idEcole = (int) $_POST["ecole"];
    $motDePasse = $_POST["mot_de_passe"];
    $confirmation = $_POST["confirmation"];

    // On valide les données
    if (empty($prenom)) {
        $erreurs[] = "Le prénom est obligatoire.";
    }

    if (empty($nom)) {
        $erreurs[] = "Le nom est obligatoire.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'adresse e-mail n'est pas valide.";
    } else {
        // On récupère ce qu'il y a après le @ (ex. "heig-vd.ch")
        $morceaux = explode("@", $email);
        $domaine = $morceaux[1];

        if (!in_array($domaine, $domainesAutorises)) {
            $erreurs[] = "Utilise ton adresse e-mail d'école (@heig-vd.ch, @epfl.ch ou @unil.ch).";
        } elseif ($utilisateurManager->trouverParEmail($email) !== null) {
            $erreurs[] = "Un compte existe déjà avec cette adresse e-mail.";
        }
    }

    if (empty($telephone)) {
        $erreurs[] = "Le numéro WhatsApp est obligatoire.";
    } elseif ($utilisateurManager->trouverParTelephone($telephone) !== null) {
        $erreurs[] = "Ce numéro de téléphone est déjà utilisé.";
    }

    if ($ecoleManager->trouverParId($idEcole) === null) {
        $erreurs[] = "Choisis ton école.";
    }

    if (strlen($motDePasse) < 8) {
        $erreurs[] = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif ($motDePasse != $confirmation) {
        $erreurs[] = "Les deux mots de passe ne sont pas identiques.";
    }

    // S'il n'y a aucune erreur, on crée le compte
    if (empty($erreurs)) {
        // On hache le mot de passe : il n'est jamais enregistré en clair
        $motDePasseHache = password_hash($motDePasse, PASSWORD_DEFAULT);

        $utilisateur = new Utilisateur(
            null,
            $prenom,
            $nom,
            $email,
            $motDePasseHache,
            "assets/img/avatar-defaut.png",
            $telephone,
            $idEcole
        );
        $utilisateurManager->ajouter($utilisateur);

        $compteCree = true;
    }
}

$titre = "Inscription – Tasty Home";
$pageActive = "inscription";
require __DIR__ . '/../includes/header.php';
?>

    <main>
        <h1 class="page-titre">Créer<br><span class="rouge">un compte</span></h1>

        <section class="formulaire">

            <?php if ($compteCree) { ?>

                <p class="message">Ton compte a bien été créé, <?= htmlspecialchars($prenom) ?> !</p>
                <a href="connexion.php" class="bouton bouton-plein">Me connecter</a>

            <?php } else { ?>

                <?php if (!empty($erreurs)) { ?>
                    <ul class="message message-erreur">
                        <?php foreach ($erreurs as $erreur) { ?>
                            <li><?= htmlspecialchars($erreur) ?></li>
                        <?php } ?>
                    </ul>
                <?php } ?>

                <form action="inscription.php" method="POST">

                    <div class="champ">
                        <label for="prenom">Prénom *</label>
                        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom) ?>" required>
                    </div>

                    <div class="champ">
                        <label for="nom">Nom *</label>
                        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom) ?>" required>
                    </div>

                    <div class="champ">
                        <label for="email">E-mail d'école *</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="prenom.nom@heig-vd.ch" required>
                    </div>

                    <div class="champ">
                        <label for="telephone">Numéro WhatsApp *</label>
                        <input type="tel" id="telephone" name="telephone" value="<?= htmlspecialchars($telephone) ?>" placeholder="079 123 45 67" required>
                    </div>

                    <div class="champ">
                        <label for="ecole">École *</label>
                        <select id="ecole" name="ecole" required>
                            <option value="">-- Choisis ton école --</option>
                            <?php foreach ($ecoles as $ecole) { ?>
                                <option value="<?= $ecole->getId() ?>" <?php if ($ecole->getId() == $idEcole) { ?>selected<?php } ?>>
                                    <?= htmlspecialchars($ecole->getNom()) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="champ">
                        <label for="mot_de_passe">Mot de passe * (8 caractères minimum)</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" minlength="8" required>
                    </div>

                    <div class="champ">
                        <label for="confirmation">Confirmer le mot de passe *</label>
                        <input type="password" id="confirmation" name="confirmation" minlength="8" required>
                    </div>

                    <button type="submit" class="bouton bouton-plein">Créer mon compte →</button>
                </form>

            <?php } ?>

        </section>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
