<?php
// cieweb/web/app.php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
// ceci ajouté pour le templating
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
// ceci ajouté pour étendre twig avec des formulaires
use Symfony\Component\Form\Forms;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;


require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../vendor/twig/twig/lib/Twig/Autoloader.php';


Twig_Autoloader::register();

function render_template($request)
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);

    return new Response(ob_get_clean());
}

function render_template_phpEngine($request, $arrayData)
{
    extract($request->attributes->all(), EXTR_SKIP);
    $loader = new FilesystemLoader(__DIR__.'/../src/pages/%name%');
    $templating = new PhpEngine(new TemplateNameParser(), $loader);

    $content = $templating->render(sprintf('%s.php', $_route), $arrayData);
    return new Response($content);
}

function render_template_twig($request, $arrayData)
{
    extract($request->attributes->all(), EXTR_SKIP);
    // les lignes qui suivent définissant les répertoires pour le templating doivent rester dans cette fonction.
    // the Twig file that holds all the default markup for rendering forms
    // this file comes with TwigBridge
    $defaultFormTheme = 'form_div_layout.html.twig';
    $appVariableReflection = new \ReflectionClass('\Symfony\Bridge\Twig\AppVariable');
    $vendorTwigBridgeDir = dirname($appVariableReflection->getFileName());
    // the path to your other templates
    $viewsDir = realpath(__DIR__.'/../src/twig/templates');

    $twigloader = new Twig_Loader_Filesystem(array(
	$viewsDir,
    	$vendorTwigBridgeDir.'/Resources/views/Form',
    ));
    
    $twig = new Twig_Environment($twigloader, array(
 		//'cache' => __DIR__.'/../src/twig/cache', ******************* j'ai commenté la ligne pour éviter la mise en cache, phase de dev'
    ));
    $formEngine = new TwigRendererEngine(array($defaultFormTheme), $twig);
    $twig->addRuntimeLoader(new \Twig_FactoryRuntimeLoader(array(
    		TwigRenderer::class => function () use ($formEngine) {
        				return new TwigRenderer($formEngine);
    				       },
    )));



    $twig->addExtension(
        new FormExtension()
    );

    $template = $twig->loadTemplate(sprintf('%s.html.twig', $_route));

    $content = $template->render($arrayData);
    return new Response($content);
}

// pour mettre en place le framework global -------------

$request = Request::createFromGlobals();
$routes = include __DIR__.'/../app/app.php';

$context = new Routing\RequestContext();

$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new HttpKernel\Controller\ControllerResolver();

$framework = new Cieweb\Framework($matcher, $resolver);
$response = $framework->handle($request);

$response->send();

