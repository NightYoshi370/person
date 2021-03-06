<?php


use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Del\Common\ContainerService;
use Del\Common\Config\DbCredentials;

$credentials = new DbCredentials([
    'driver' => 'pdo_mysql',
    'host' => 'localhost',
    'dbname' => 'delboy1978uk',
    'user' => 'dbuser',
    'password' => '[123456]',
]);

$container = ContainerService::getInstance()
    ->setDbCredentials($credentials)
    ->addEntityPath('src/Entity')
    ->getContainer();

/** @var Doctrine\ORM\EntityManager $em*/
$em = $container['doctrine.entity_manager'];
$helperSet = ConsoleRunner::createHelperSet($em);
$helperSet->set(new \Symfony\Component\Console\Helper\DialogHelper(),'dialog');
$cli = ConsoleRunner::createApplication($helperSet,[]);

return $cli->run();
