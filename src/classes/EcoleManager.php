<?php

class EcoleManager extends Manager
{
    public function trouverToutes(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM ecoles ORDER BY id");
        $stmt->execute();

        $ecoles = [];
        foreach ($stmt->fetchAll() as $row) {
            $ecoles[] = new Ecole($row['id'], $row['nom_ecole']);
        }
        return $ecoles;
    }

    public function trouverParId(int $id): ?Ecole
    {
        $stmt = $this->pdo->prepare("SELECT * FROM ecoles WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? new Ecole($row['id'], $row['nom_ecole']) : null;
    }
}
