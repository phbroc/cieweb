<?php
// cieweb/src/Cieweb/Validator/Constraints/PersonneUniquePseudo.php
namespace Cieweb\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class PersonneUniquePseudo extends Constraint
{
  public $message = 'Le pseudo "%string%" est déjà utilisé.';
}
