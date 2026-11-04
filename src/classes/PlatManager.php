<?php

class PlatManager extends Manager
{
    public function trouverParId(int $id): ?Plat
    {
        $stmt = $this->pdo->prepare("SELECT * FROM plats WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? $this->creerPlat($row) : null;
    }

    public function trouverParDate(string $date, array $idsEtiquettes = [], ?int $idEcole = null): array
    {
        $sql = "SELECT p.* FROM plats p
                JOIN utilisateurs u ON u.id = p.id_utilisateur
                WHERE p.date_de_disponibilite = ? AND p.nombre_de_portion > 0";
        $parametres = [$date];

        if ($idEcole !== null) {
            $sql .= " AND u.id_ecole = ?";
            $parametres[] = $idEcole;
        }

        foreach ($idsEtiquettes as $idEtiquette) {
            $sql .= " AND EXISTS (SELECT 1 FROM plats_etiquettes pe WHERE pe.id_plat = p.id AND pe.id_etiquette = ?)";
            $parametres[] = $idEtiquette;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($parametres);
        return $this->creerPlats($stmt->fetchAll());
    }

    public function trouverParUtilisateur(int $id_utilisateur): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM plats WHERE id_utilisateur = ?");
        $stmt->execute([$id_utilisateur]);
        return $this->creerPlats($stmt->fetchAll());
    }

    public function ajouter(Plat $p): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO plats (nom_du_plat, description, photo_du_plat, nombre_de_portion, date_de_disponibilite, id_utilisateur)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $p->getNom(), $p->getDescription(), $p->getPhoto(),
            $p->getNombreDePortion(), $p->getDateDeDisponibilite(), $p->getIdUtilisateur()
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function modifier(Plat $p): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE plats
            SET nom_du_plat = ?, description = ?, photo_du_plat = ?, nombre_de_portion = ?, date_de_disponibilite = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $p->getNom(), $p->getDescription(), $p->getPhoto(),
            $p->getNombreDePortion(), $p->getDateDeDisponibilite(), $p->getId()
        ]);
    }

    public function supprimer(int $id): void
    {
        $this->pdo->prepare("DELETE FROM plats_etiquettes WHERE id_plat = ?")->execute([$id]);
        $this->pdo->prepare("DELETE FROM plats WHERE id = ?")->execute([$id]);
    }

    private function creerPlat(array $row): Plat
    {
        return new Plat(
            $row['id'], $row['nom_du_plat'], $row['description'], $row['photo_du_plat'],
            $row['nombre_de_portion'], $row['date_de_disponibilite'], $row['id_utilisateur']
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
