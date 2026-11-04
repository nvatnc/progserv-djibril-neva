<?php
require __DIR__ . '/../includes/bootstrap.php';

$ecoleManager = new EcoleManager();
$ecoles = $ecoleManager->trouverToutes();

$titre = 'Tasty Home';
$pageActive = '';
require __DIR__ . '/../includes/header.php';
?>

    <main class="accueil">

        <!-- Colonne de gauche : texte -->
        <section class="accueil-texte">
            <p class="sur-titre">
                <?php foreach ($ecoles as $i => $ecole) { ?>
                    <?= $i > 0 ? ' · ' : '' ?><?= htmlspecialchars($ecole->getNom()) ?>
                <?php } ?>
            </p>

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
            <img src="/assets/img/accueil.jpg" alt="Assiette de pâtes maison">
        </div>

    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
