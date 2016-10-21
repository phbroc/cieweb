<?php
// cieweb/app/doctrine.php

// ceci ajouté pour utiliser Doctrine
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once __DIR__.'/../vendor/autoload.php';

// pour utiliser doctrine --------------------------------
function GetEntityManager() {
  $isDevMode = true; // lié à doctrine
  $config = Setup::createYAMLMetadataConfiguration(array(__DIR__.'/config/'), $isDevMode);
  // database configuration parameters

  $conn = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'foo6',
    'password' => 'foo6pwd',
    'dbname'   => 'cieweb',
  );

  // obtaining the entity manager
  $entityManager = EntityManager::create($conn, $config);
  return $entityManager;
}
