<?php

class EtiquetteManager extends Manager
{
    public function trouverToutes(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT e.id, e.nom_etiquette, c.nom_de_la_categorie
            FROM etiquettes e
            JOIN categories c ON e.id_categorie = c.id
            ORDER BY c.id, e.id
        ");
        $stmt->execute();
        return $this->creerEtiquettes($stmt->fetchAll());
    }

    public function trouverParPlat(int $id_plat): array
    {
        $stmt = $this->pdo->prepare("
            SELECT e.id, e.nom_etiquette, c.nom_de_la_categorie
            FROM etiquettes e
            JOIN categories c ON e.id_categorie = c.id
            JOIN plats_etiquettes pe ON pe.id_etiquette = e.id
            WHERE pe.id_plat = ?
        ");
        $stmt->execute([$id_plat]);
        return $this->creerEtiquettes($stmt->fetchAll());
    }

    public function ajouterAuPlat(int $id_plat, int $id_etiquette): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO plats_etiquettes (id_plat, id_etiquette) VALUES (?, ?)");
        $stmt->execute([$id_plat, $id_etiquette]);
    }

    private function creerEtiquettes(array $rows): array
    {
        $etiquettes = [];
        foreach ($rows as $row) {
            $etiquettes[] = new Etiquette($row['id'], $row['nom_etiquette'], $row['nom_de_la_categorie']);
        }
        return $etiquettes;
    }
}
