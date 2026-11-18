<?php

class EtiquetteManager extends Manager
{
    public function trouverToutes(): array
    {
        $sql = "SELECT e.id, e.nom_etiquette, c.nom_de_la_categorie
                FROM etiquettes e
                JOIN categories c ON e.id_categorie = c.id
                ORDER BY c.id, e.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $this->creerEtiquettes($stmt->fetchAll());
    }

    public function trouverParPlat(int $id_plat): array
    {
        $sql = "SELECT e.id, e.nom_etiquette, c.nom_de_la_categorie
                FROM etiquettes e
                JOIN categories c ON e.id_categorie = c.id
                JOIN plats_etiquettes pe ON pe.id_etiquette = e.id
                WHERE pe.id_plat = :id_plat";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id_plat', $id_plat);
        $stmt->execute();

        return $this->creerEtiquettes($stmt->fetchAll());
    }

    public function ajouterAuPlat(int $id_plat, int $id_etiquette): void
    {
        $sql = "INSERT INTO plats_etiquettes (id_plat, id_etiquette) VALUES (:id_plat, :id_etiquette)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id_plat', $id_plat);
        $stmt->bindValue(':id_etiquette', $id_etiquette);
        $stmt->execute();
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
