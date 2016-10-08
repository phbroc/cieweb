<?php
// cieweb/src/Cieweb/Controller/PersonneNouveauController.php
namespace Cieweb\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class PersonneNouveauController
{
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
            ->add('phrase', TextType::class)
            ->add('admin', CheckboxType::class)
            ->add('save', ButtonType::class)
            ->getForm();
        
        $response = render_template_twig($request, array(
            'form' => $form->createView(),
        ));
        return $response;
    }
}