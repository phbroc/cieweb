<?php
// cieweb/web/front.php
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../vendor/twig/twig/lib/Twig/Autoloader.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
// ceci ajouté pour le templating
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
// ceci ajouté pour étendre twig avec des formulaires
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;

Twig_Autoloader::register();

define('DEFAULT_FORM_THEME', 'form_div_layout.html.twig');


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
    
    $twigloader = new Twig_Loader_Filesystem(__DIR__.'/../src/twig/templates');
    $twig = new Twig_Environment($twigloader, array(
 //       'cache' => __DIR__.'/../src/twig/cache', ****************************** j'ai commenté la ligne pour éviter la mise en cache, phase de dev'
    ));
    
    $formEngine = new TwigRendererEngine(array(DEFAULT_FORM_THEME));
    $formEngine->setEnvironment($twig);
    
    $twig->addExtension(
        new FormExtension(new TwigRenderer($formEngine))
    );
    
    $template = $twig->loadTemplate(sprintf('%s.html.twig', $_route));

    $content = $template->render($arrayData);
    return new Response($content);
}

$request = Request::createFromGlobals();
$routes = include __DIR__.'/../app/app.php';

$context = new Routing\RequestContext();
//$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new HttpKernel\Controller\ControllerResolver();

$framework = new Cieweb\Framework($matcher, $resolver);
$response = $framework->handle($request);

$response->send();
?>