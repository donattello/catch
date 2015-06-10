<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('default', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'classname' => 'Propel\\Runtime\\Connection\\ConnectionWrapper',
  'dsn' => 'mysql:host=localhost;dbname=login',
  'user' => 'root',
  'password' => 'password',
    
//    'dsn' => 'mysql:host=localhost;dbname=gradProject',
//  'user' => 'martinkiss',
//  'password' => 'Bournemouth123',
  'attributes' =>
  array (
    'ATTR_EMULATE_PREPARES' => false,
  ),
));
$manager->setName('default');
$serviceContainer->setConnectionManager('default', $manager);
$serviceContainer->setDefaultDatasource('default');