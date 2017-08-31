<?php
// cieweb/app/app.php
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;


// look inside *app* directory
$locator = new FileLocator(array(__DIR__.'/../app/config'));
$loader = new YamlFileLoader($locator);
$routes = $loader->load('routes.yml');

return $routes;
