<?php
// cieweb/src/Cieweb/Validator/Constraints/PersonneUniquePseudoValidator.php
namespace Cieweb\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use Cieweb\Entity\Personne;
use Doctrine\ORM\EntityManager;

class PersonneUniquePseudoValidator extends ConstraintValidator
{
  protected $entityManager;

  public function __construct()
  {
      require_once __DIR__.'/../../../../app/doctrine.php';
      $this->entityManager = GetEntityManager();
  }


  public function validate($value, Constraint $constraint)
  {
    $personnesRepository = $this->entityManager->getRepository('Cieweb\Entity\Personne');
    $personnes = $personnesRepository->findBy(array('pseudo' => $value));
    $availablePseudo = count($personnes);

    if ($availablePseudo > 0) {
      $this->context->buildViolation($constraint->message)
        ->setParameter('%string%', $value)
        ->addViolation();
    }
  }


}
