<?php
// web/cli-config.php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once 'doctrine.php';

// replace with mechanism to retrieve EntityManager in your app
// déjà appelé dans doctrine.php
$entityManager = GetEntityManager();

return ConsoleRunner::createHelperSet($entityManager);
