<?php
// web/cli-config.php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once 'front.php';

// replace with mechanism to retrieve EntityManager in your app
// déjà appelé dans front.php
// $entityManager = GetEntityManager(); 

return ConsoleRunner::createHelperSet($entityManager);
?>