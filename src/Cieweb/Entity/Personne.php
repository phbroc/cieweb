<?php
// cieweb/src/Cieweb/Entity/Personne.php
namespace Cieweb\Entity;

class Personne
{
    protected $id_personne;
    protected $pseudo;
    protected $email;
    protected $nom;
    protected $prenom;
    protected $passe;
    protected $phrase;
    protected $admin;
    
    public function getId_personne()
    {
        return $this->id_personne;
    }
    
    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }
    
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    
    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }
    
    public function getPasse()
    {
        return $this->passe;
    }

    public function setPasse($passe)
    {
        $this->passe = $passe;
    }
    
    public function getPhrase()
    {
        return $this->phrase;
    }

    public function setPhrase($phrase)
    {
        $this->phrase = $phrase;
    }
    
    public function getAdmin()
    {
        return $this->admin;
    }

    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }
    

    
}