<?php

class Utilisateur
{
    private ?int $id;
    private string $prenom;
    private string $nom;
    private string $email;
    private string $mot_de_passe;
    private string $photo_de_profil;
    private string $numero_de_telephone;
    private int $id_ecole;

    public function __construct(?int $id, string $prenom, string $nom, string $email, string $mot_de_passe, string $photo_de_profil, string $numero_de_telephone, int $id_ecole)
    {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->email = $email;
        $this->mot_de_passe = $mot_de_passe;
        $this->photo_de_profil = $photo_de_profil;
        $this->numero_de_telephone = $numero_de_telephone;
        $this->id_ecole = $id_ecole;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMotDePasse(): string
    {
        return $this->mot_de_passe;
    }

    public function getPhotoDeProfil(): string
    {
        return $this->photo_de_profil;
    }

    public function getNumeroDeTelephone(): string
    {
        return $this->numero_de_telephone;
    }

    public function getIdEcole(): int
    {
        return $this->id_ecole;
    }

    public function getNomAffiche(): string
    {
        return $this->prenom . ' ' . mb_substr($this->nom, 0, 1) . '.';
    }

    public function verifierMotDePasse(string $mot_de_passe): bool
    {
        return password_verify($mot_de_passe, $this->mot_de_passe);
    }
}
