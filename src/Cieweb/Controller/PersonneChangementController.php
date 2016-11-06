<?php
// cieweb/src/Cieweb/Controller/PersonneChangementController.php
namespace Cieweb\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Validation;

use Cieweb\Entity\Personne;
use Doctrine\ORM\EntityManager;

class PersonneChangementController
{
    protected $entityManager;

    public function __construct()
    {
        require_once __DIR__.'/../../../app/doctrine.php';
        $this->entityManager = GetEntityManager();
    }

    public function indexAction(Request $request, $id_personne)
    {
        $personnesRepository = $this->entityManager->getRepository('Cieweb\Entity\Personne');
        $personne = $personnesRepository->find($id_personne);

        if (!$personne) {
          throw $this->createNotFoundException('pas de Personne pour l\'ID '.$id_personne);
        }

        $defaults = array(
          'pseudo' => $personne->getPseudo(),
          'email' => $personne->getEmail(),
          'prenom' => $personne->getPrenom(),
          'nom' => $personne->getNom(),
          'passe' => $personne->getPasse(),
          'phrase' => $personne->getPhrase(),
          'admin' => $personne->getAdmin(),
        );

        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->getFormFactory();

        $form = $formFactory->createBuilder(FormType::class, $defaults)
            ->add('pseudo', TextType::class)
            ->add('email', EmailType::class)
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('passe', PasswordType::class)
            ->add('passeConfirme', PasswordType::class)
            ->add('phrase', TextType::class)
            ->add('admin', ChoiceType::class, array(
              'choices'  => array(
                'Rédacteur' => 'N',
                'Administrateur' => 'Y',
              )))
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        $debug = "ID:".$id_personne." ";
        $errors = array();
        // custom validation outside form validation
        $errorsCustom = array();


        if ($form->isValid()) {
            $debug .= " Form is valid.";
            $data = $form->getData();
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
              $this->entityManager->persist($personne);
              $this->entityManager->flush();
              $debug .= " Personne updated with ID: ". $personne->getId_personne();
            }

        } else {
            $debug .= " Form isn't valid.";
        }

        $response = render_template_twig($request, array(
            'form' => $form->createView(),
            'errors' => $errors,
            'errorsCustom' => $errorsCustom,
            'debug' => $debug,
        ));
        return $response;
    }
}
