<?php

class EcoleManager extends Manager
{
    public function trouverToutes(): array
    {
        $sql = "SELECT * FROM ecoles ORDER BY id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $ecoles = [];
        foreach ($stmt->fetchAll() as $row) {
            $ecoles[] = new Ecole($row['id'], $row['nom_ecole']);
        }
        return $ecoles;
    }

    public function trouverParId(int $id): ?Ecole
    {
        $sql = "SELECT * FROM ecoles WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }
        return new Ecole($row['id'], $row['nom_ecole']);
    }
}
