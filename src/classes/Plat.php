<?php

class Plat
{
    private ?int $id;
    private string $nom_du_plat;
    private string $description;
    private ?string $photo_du_plat;
    private int $nombre_de_portion;
    private string $date_de_disponibilite;
    private int $id_utilisateur;

    public function __construct(?int $id, string $nom_du_plat, string $description, ?string $photo_du_plat, int $nombre_de_portion, string $date_de_disponibilite, int $id_utilisateur)
    {
        if ($nombre_de_portion < 0) {
            throw new InvalidArgumentException("Le nombre de portions ne peut pas être négatif.");
        }

        $this->id = $id;
        $this->nom_du_plat = $nom_du_plat;
        $this->description = $description;
        $this->photo_du_plat = $photo_du_plat;
        $this->nombre_de_portion = $nombre_de_portion;
        $this->date_de_disponibilite = $date_de_disponibilite;
        $this->id_utilisateur = $id_utilisateur;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom_du_plat;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPhoto(): ?string
    {
        return $this->photo_du_plat;
    }

    public function getNombreDePortion(): int
    {
        return $this->nombre_de_portion;
    }

    public function getDateDeDisponibilite(): string
    {
        return $this->date_de_disponibilite;
    }

    public function getIdUtilisateur(): int
    {
        return $this->id_utilisateur;
    }

    public function appartientA(int $id_utilisateur): bool
    {
        return $this->id_utilisateur === $id_utilisateur;
    }
}
