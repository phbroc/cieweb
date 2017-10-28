<?php
// cieweb/src/Cieweb/Controller/PersonneNouveauController.php
namespace Cieweb\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Validation;

use Cieweb\Entity\Personne;
use Doctrine\ORM\EntityManager;

class PersonneNouveauController
{
    protected $entityManager;

    public function __construct()
    {
        require_once __DIR__.'/../../../app/doctrine.php';
        $this->entityManager = GetEntityManager();
    }

    public function indexAction(Request $request)
    {
        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->getFormFactory();

        $form = $formFactory->createBuilder()
            ->add('pseudo', TextType::class)
            ->add('email', EmailType::class)
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('passe', PasswordType::class)
            ->add('passeConfirme', PasswordType::class)
            ->add('phrase', TextType::class)
            ->add('admin', CheckboxType::class, array('required' => false,))
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        $debug = "";
        $errors = array();
        // custom validation outside form validation
        $errorsCustom = array();

        if ($form->isValid()) {
            $data = $form->getData();
            $debug .= " Form is valid.";
            $personne = new Personne();
            $personne->setPseudo($data['pseudo']);
            $personne->setEmail($data['email']);
            $personne->setNom($data['nom']);
            $personne->setPrenom($data['prenom']);
            $personne->setPasse($data['passe']);
            $personne->setPhrase($data['phrase']);
            $personne->setAdmin($data['admin']);

            $validator = Validation::createValidatorBuilder()
              ->addMethodMapping('loadValidatorMetadata')
              ->getValidator();
            $errors = $validator->validate($personne);

            // RepeatedType Field ne fonctionne pas dans ma configuration, donc j'ajoute une validation perso.
            if ($data['passe'] != $data['passeConfirme']) array_push(
                $errorsCustom, 'Vous devez saisir le mot de passe deux fois de façon identique.'
              );

            if ((count($errors) > 0) || (count($errorsCustom) > 0)) {
              $debug .= " Validation error...";
            } else {
              // la transformation md5 du passe doit se faire maintenant
              $personne->setPasse(md5($data['passe']));
              $this->entityManager->persist($personne);
              $this->entityManager->flush();
              $debug .= " Personne added with ID: ". $personne->getId_personne();
            }
        } else {
            $debug .= " Form isn't valid.";
        }

        $response = render_template_twig($request, array(
            'form' => $form->createView(),
            'debug' => $debug,
            'errors' => $errors,
            'errorsCustom' => $errorsCustom,
        ));
        return $response;
    }
}
