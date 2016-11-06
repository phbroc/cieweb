<?php
// cieweb/src/Cieweb/Entity/Personne.php
namespace Cieweb\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Cieweb\Validator\Constraints\PersonneUniquePseudo;

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

    /**
    * This method is where you define your validation rules.
    */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
      // valid pseudo is 5-20 characters long
      $metadata->addPropertyConstraint('pseudo', new Assert\Length(array(
        'min' => 3,
        'max' => 20,
        'minMessage' => 'Le pseudo doit avoir une longueur minimum de 3 caractères.',
        'maxMessage' => 'Le pseudo doit avoir une longueur maximum de 20 caractères.',
      )));
      $metadata->addPropertyConstraint('pseudo', new PersonneUniquePseudo());
    }

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
