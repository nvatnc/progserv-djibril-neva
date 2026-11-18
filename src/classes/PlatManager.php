<?php

class PlatManager extends Manager
{
    public function trouverParId(int $id): ?Plat
    {
        $sql = "SELECT * FROM plats WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }
        return $this->creerPlat($row);
    }

    public function trouverParDate(string $date, array $idsEtiquettes = [], ?int $idEcole = null): array
    {
        $sql = "SELECT p.* FROM plats p
                JOIN utilisateurs u ON u.id = p.id_utilisateur
                WHERE p.date_de_disponibilite = :date AND p.nombre_de_portion > 0";

        if ($idEcole !== null) {
            $sql = $sql . " AND u.id_ecole = :id_ecole";
        }

        foreach ($idsEtiquettes as $numero => $idEtiquette) {
            $sql = $sql . " AND EXISTS (SELECT 1 FROM plats_etiquettes pe
                                        WHERE pe.id_plat = p.id AND pe.id_etiquette = :etiquette" . $numero . ")";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':date', $date);

        if ($idEcole !== null) {
            $stmt->bindValue(':id_ecole', $idEcole);
        }

        foreach ($idsEtiquettes as $numero => $idEtiquette) {
            $stmt->bindValue(':etiquette' . $numero, $idEtiquette);
        }

        $stmt->execute();
        return $this->creerPlats($stmt->fetchAll());
    }

    public function trouverParUtilisateur(int $id_utilisateur): array
    {
        $sql = "SELECT * FROM plats WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur);
        $stmt->execute();

        return $this->creerPlats($stmt->fetchAll());
    }

    public function ajouter(Plat $plat): int
    {
        $sql = "INSERT INTO plats (nom_du_plat, description, photo_du_plat, nombre_de_portion, date_de_disponibilite, id_utilisateur)
                VALUES (:nom_du_plat, :description, :photo_du_plat, :nombre_de_portion, :date_de_disponibilite, :id_utilisateur)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nom_du_plat', $plat->getNom());
        $stmt->bindValue(':description', $plat->getDescription());
        $stmt->bindValue(':photo_du_plat', $plat->getPhoto());
        $stmt->bindValue(':nombre_de_portion', $plat->getNombreDePortion());
        $stmt->bindValue(':date_de_disponibilite', $plat->getDateDeDisponibilite());
        $stmt->bindValue(':id_utilisateur', $plat->getIdUtilisateur());
        $stmt->execute();

        return (int) $this->pdo->lastInsertId();
    }

    public function modifier(Plat $plat): void
    {
        $sql = "UPDATE plats
                SET nom_du_plat = :nom_du_plat,
                    description = :description,
                    photo_du_plat = :photo_du_plat,
                    nombre_de_portion = :nombre_de_portion,
                    date_de_disponibilite = :date_de_disponibilite
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nom_du_plat', $plat->getNom());
        $stmt->bindValue(':description', $plat->getDescription());
        $stmt->bindValue(':photo_du_plat', $plat->getPhoto());
        $stmt->bindValue(':nombre_de_portion', $plat->getNombreDePortion());
        $stmt->bindValue(':date_de_disponibilite', $plat->getDateDeDisponibilite());
        $stmt->bindValue(':id', $plat->getId());
        $stmt->execute();
    }

    public function supprimer(int $id): void
    {
        $sql = "DELETE FROM plats_etiquettes WHERE id_plat = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $sql = "DELETE FROM plats WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    private function creerPlat(array $row): Plat
    {
        return new Plat(
            $row['id'],
            $row['nom_du_plat'],
            $row['description'],
            $row['photo_du_plat'],
            $row['nombre_de_portion'],
            $row['date_de_disponibilite'],
            $row['id_utilisateur']
        );
    }

    private function creerPlats(array $rows): array
    {
        $plats = [];
        foreach ($rows as $row) {
            $plats[] = $this->creerPlat($row);
        }
        return $plats;
    }
}
