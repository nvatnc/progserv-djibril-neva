<?php

class UtilisateurManager extends Manager
{
    public function trouverParId(int $id): ?Utilisateur
    {
        $sql = "SELECT * FROM utilisateurs WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $this->creerUtilisateur($stmt->fetch());
    }

    public function trouverParEmail(string $email): ?Utilisateur
    {
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $this->creerUtilisateur($stmt->fetch());
    }

    public function trouverParTelephone(string $telephone): ?Utilisateur
    {
        $sql = "SELECT * FROM utilisateurs WHERE numero_de_telephone = :telephone";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':telephone', $telephone);
        $stmt->execute();

        return $this->creerUtilisateur($stmt->fetch());
    }

    public function ajouter(Utilisateur $utilisateur): int
    {
        $sql = "INSERT INTO utilisateurs (prenom, nom, email, mot_de_passe, photo_de_profil, numero_de_telephone, id_ecole)
                VALUES (:prenom, :nom, :email, :mot_de_passe, :photo_de_profil, :numero_de_telephone, :id_ecole)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':prenom', $utilisateur->getPrenom());
        $stmt->bindValue(':nom', $utilisateur->getNom());
        $stmt->bindValue(':email', $utilisateur->getEmail());
        $stmt->bindValue(':mot_de_passe', $utilisateur->getMotDePasse());
        $stmt->bindValue(':photo_de_profil', $utilisateur->getPhotoDeProfil());
        $stmt->bindValue(':numero_de_telephone', $utilisateur->getNumeroDeTelephone());
        $stmt->bindValue(':id_ecole', $utilisateur->getIdEcole());
        $stmt->execute();

        return (int) $this->pdo->lastInsertId();
    }

    private function creerUtilisateur($row): ?Utilisateur
    {
        if (!$row) {
            return null;
        }

        return new Utilisateur(
            $row['id'],
            $row['prenom'],
            $row['nom'],
            $row['email'],
            $row['mot_de_passe'],
            $row['photo_de_profil'],
            $row['numero_de_telephone'],
            $row['id_ecole']
        );
    }
}
