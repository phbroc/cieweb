<?php
// cieweb/src/Cieweb/Controller/PersonneListeController.php
namespace Cieweb\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Cieweb\Entity\Personne;
use Doctrine\ORM\EntityManager;

class PersonneListeController
{
    protected $entityManager;

    public function __construct()
    {
        require_once __DIR__.'/../../../app/doctrine.php';
        $this->entityManager = GetEntityManager();
    }

    public function indexAction(Request $request)
    {
        $personnesRepository = $this->entityManager->getRepository('Cieweb\Entity\Personne');
        $personnes = $personnesRepository->findAll();

        $response = render_template_twig($request, array(
            'personnes' => $personnes
        ));
        return $response;
    }
}
