<?php
// cieweb/src/Cieweb/Controller/EntreeController.php
namespace Cieweb\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EntreeController
{
    public function indexAction(Request $request)
    {
        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->getFormFactory();

        $form = $formFactory->createBuilder()
            ->add('pseudo', TextType::class)
            ->add('passe', PasswordType::class)
            ->add('entree', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        $response = render_template_twig($request, array(
            'form' => $form->createView(),
        ));
        return $response;
    }
}
