<?php

class UtilisateurManager extends Manager
{
    public function trouverParId(int $id): ?Utilisateur
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? $this->creerUtilisateur($row) : null;
    }

    public function trouverParEmail(string $email): ?Utilisateur
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ? $this->creerUtilisateur($row) : null;
    }

    public function ajouter(Utilisateur $u): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO utilisateurs (prenom, nom, email, mot_de_passe, photo_de_profil, numero_de_telephone, id_ecole)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $u->getPrenom(), $u->getNom(), $u->getEmail(), $u->getMotDePasse(),
            $u->getPhotoDeProfil(), $u->getNumeroDeTelephone(), $u->getIdEcole()
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    private function creerUtilisateur(array $row): Utilisateur
    {
        return new Utilisateur(
            $row['id'], $row['prenom'], $row['nom'], $row['email'], $row['mot_de_passe'],
            $row['photo_de_profil'], $row['numero_de_telephone'], $row['id_ecole']
        );
    }
}
