<?php
require __DIR__ . '/../includes/bootstrap.php';

$platManager = new PlatManager();
$etiquetteManager = new EtiquetteManager();
$ecoleManager = new EcoleManager();
$utilisateurManager = new UtilisateurManager();

// ----- Les 7 jours de la semaine en cours (onglets) -----
$nomsDesJours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
$lundi = new DateTime('monday this week');

$jours = [];
foreach ($nomsDesJours as $i => $nom) {
    $date = (clone $lundi)->modify("+$i day");
    $jours[] = ['nom' => $nom, 'date' => $date->format('Y-m-d')];
}

// ----- Le jour choisi (dans l'URL : ?jour=2026-11-04), aujourd'hui par défaut -----
$jourChoisi = $_GET['jour'] ?? date('Y-m-d');
$dateValide = DateTime::createFromFormat('Y-m-d', $jourChoisi);
if (!$dateValide || $dateValide->format('Y-m-d') !== $jourChoisi) {
    $jourChoisi = date('Y-m-d');
}

// ----- Les filtres choisis (cases à cocher) -----
$idsEtiquettes = array_map('intval', $_GET['etiquettes'] ?? []);
$idEcole = !empty($_GET['ecole']) ? (int) $_GET['ecole'] : null;

// ----- Les données -----
$plats = $platManager->trouverParDate($jourChoisi, $idsEtiquettes, $idEcole);
$etiquettes = $etiquetteManager->trouverToutes();
$ecoles = $ecoleManager->trouverToutes();

// Les étiquettes regroupées par catégorie ("Type de plat", "Ingrédients")
$groupes = [];
foreach ($etiquettes as $etiquette) {
    $groupes[$etiquette->getCategorie()][] = $etiquette;
}

// Les filtres restent ouverts si au moins un filtre est actif
$filtresActifs = !empty($idsEtiquettes) || $idEcole !== null;

// Lien d'un onglet : on change le jour mais on garde les filtres
function lienJour(string $date, array $idsEtiquettes, ?int $idEcole): string
{
    return '?' . http_build_query(['jour' => $date, 'etiquettes' => $idsEtiquettes, 'ecole' => $idEcole]);
}

$titre = 'Plats – Tasty Home';
$pageActive = 'plats';
require __DIR__ . '/../includes/header.php';
?>

    <main>
        <h1 class="page-titre">Plats<br>disponibles</h1>

        <!-- Onglets des jours -->
        <nav class="jours">
            <?php foreach ($jours as $jour) { ?>
                <a href="<?= htmlspecialchars(lienJour($jour['date'], $idsEtiquettes, $idEcole)) ?>"
                    class="<?= $jour['date'] === $jourChoisi ? 'actif' : '' ?>">
                    <?= $jour['nom'] ?>
                </a>
            <?php } ?>
        </nav>

        <!-- Filtres -->
        <details class="filtres" <?= $filtresActifs ? 'open' : '' ?>>
            <summary>Filtres</summary>

            <form method="get" class="filtres-contenu">
                <input type="hidden" name="jour" value="<?= htmlspecialchars($jourChoisi) ?>">

                <?php foreach ($groupes as $categorie => $etiquettesDuGroupe) { ?>
                    <fieldset class="filtres-groupe">
                        <legend class="sur-titre"><?= htmlspecialchars($categorie) ?></legend>

                        <?php foreach ($etiquettesDuGroupe as $etiquette) { ?>
                            <label class="tag">
                                <input type="checkbox" name="etiquettes[]" value="<?= $etiquette->getId() ?>"
                                    <?= in_array($etiquette->getId(), $idsEtiquettes) ? 'checked' : '' ?>>
                                <span><?= htmlspecialchars($etiquette->getNom()) ?></span>
                            </label>
                        <?php } ?>
                    </fieldset>
                <?php } ?>

                <fieldset class="filtres-groupe">
                    <legend class="sur-titre">École</legend>

                    <?php foreach ($ecoles as $ecole) { ?>
                        <label class="tag">
                            <input type="radio" name="ecole" value="<?= $ecole->getId() ?>"
                                <?= $ecole->getId() === $idEcole ? 'checked' : '' ?>>
                            <span><?= htmlspecialchars($ecole->getNom()) ?></span>
                        </label>
                    <?php } ?>
                </fieldset>

                <div class="filtres-boutons">
                    <button type="submit" class="bouton bouton-plein">Appliquer</button>
                    <a href="?jour=<?= htmlspecialchars($jourChoisi) ?>" class="bouton bouton-contour">Réinitialiser</a>
                </div>
            </form>
        </details>

        <!-- Cartes des plats -->
        <?php if (empty($plats)) { ?>
            <p class="aucun-plat">Aucun plat ce jour</p>
        <?php } else { ?>
            <div class="grille-plats">
                <?php foreach ($plats as $plat) {
                    $cuisinier = $utilisateurManager->trouverParId($plat->getIdUtilisateur());
                    $ecole = $ecoleManager->trouverParId($cuisinier->getIdEcole());
                    $photoExiste = $plat->getPhoto() && file_exists(__DIR__ . '/' . $plat->getPhoto());
                ?>
                    <a href="/plat.php?id=<?= $plat->getId() ?>" class="carte-plat">
                        <?php if ($photoExiste) { ?>
                            <img class="carte-photo" src="/<?= htmlspecialchars($plat->getPhoto()) ?>" alt="<?= htmlspecialchars($plat->getNom()) ?>">
                        <?php } else { ?>
                            <div class="carte-photo carte-photo-vide"></div>
                        <?php } ?>

                        <div class="carte-infos">
                            <h2 class="carte-nom"><?= htmlspecialchars($plat->getNom()) ?></h2>
                            <div class="carte-bas">
                                <span class="carte-meta">
                                    <?= htmlspecialchars($ecole->getNom()) ?> · <?= htmlspecialchars($cuisinier->getNomAffiche()) ?>
                                </span>
                                <span class="carte-portions"><?= $plat->getNombreDePortion() ?> portions</span>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        <?php } ?>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
