<?php
// cieweb/src/Cieweb/Controller/PersonneSuppressionController.php
namespace Cieweb\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Cieweb\Entity\Personne;
use Doctrine\ORM\EntityManager;

class PersonneSuppressionController
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

        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->getFormFactory();

        $form = $formFactory->createBuilder(FormType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        $debug = "ID:".$id_personne." ";
        if ($form->isValid()) {
            $this->entityManager->remove($personne);
            $this->entityManager->flush();
            $debug .= " Form is valid.";

        } else {
            $debug .= " Form isn't valid.";
        }

        $response = render_template_twig($request, array(
            'form' => $form->createView(),
            'personne' => $personne,
            'debug' => $debug,
        ));
        return $response;
    }
}
