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
      // valid pseudo is 4-20 characters long
      $metadata->addPropertyConstraint('pseudo', new Assert\Length(array(
        'min' => 4,
        'max' => 20,
        'minMessage' => 'Le pseudo doit avoir une longueur minimum de 4 caractères.',
        'maxMessage' => 'Le pseudo doit avoir une longueur maximum de 20 caractères.',
      )));
      // custom validation le pseudo doit être unique.
      $metadata->addPropertyConstraint('pseudo', new PersonneUniquePseudo());
      // majuscule minuscule chiffre sont les seuls autorisés dans pseudo
      $metadata->addPropertyConstraint('pseudo', new Assert\Regex(array(
        'pattern' => '/^[a-zA-Z0-9]*$/',
        'message' => 'Le pseudo doit contenir uniquement des lettres sans accents et des chiffres, sans espace.',
      )));
      // passe ne doit contenir que majuscule minuscule chiffre et quelques caractères spéciaux
      $metadata->addPropertyConstraint('passe', new Assert\Regex(array(
        'pattern' => '/^[a-zA-Z0-9\+\-\/\*\$_]*$/',
        'message' => 'Le mot de passe doit contenir uniquement des lettres ou des chiffres ou des caractères accentués comme +-/*$_, sans espace.',
      )));
      // passe a une longueur entre 4 et 8
      $metadata->addPropertyConstraint('passe', new Assert\Length(array(
        'min' => 4,
        'max' => 8,
        'minMessage' => 'Le passe doit avoir une longueur minimum de 4 caractères.',
        'maxMessage' => 'Le passe doit avoir une longueur maximum de 8 caractères.',
      )));
      // le nom ne doit pas contenir de balise html
      $metadata->addPropertyConstraint('nom', new Assert\Regex(array(
        'pattern' => '/[<>]/',
        'match'   => false,
        'message' => 'Le nom ne doit pas contenir les caractères < et >.',
      )));
      // le prenom ne doit pas contenir de balise html
      $metadata->addPropertyConstraint('prenom', new Assert\Regex(array(
        'pattern' => '/[<>]/',
        'match'   => false,
        'message' => 'Le nom ne doit pas contenir les caractères < et >.',
      )));
      // la phrase ne doit pas contenir de balise html
      $metadata->addPropertyConstraint('phrase', new Assert\Regex(array(
        'pattern' => '/<[^>]*>/',
        'match'   => false,
        'message' => 'La phrase aide mémoire ne doit pas contenir de balise HTML.',
      )));
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
