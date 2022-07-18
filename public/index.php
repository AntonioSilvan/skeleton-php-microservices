<?php
declare(strict_types = 1);
require(__DIR__ . '/../bootstrap.php');

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use PetFoundation\Http\Kernel;

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../src/config'));
$loader->load('services.yaml');
$container->compile();

/*
|----------------------------------------
| Se inicia el Kernel
|----------------------------------------
| Se inicia el kernel donde se configura
| el comportamiento de las rutas y el
| container de la iyeccion de dependencias
*/
try{
    $request = Request::createFromGlobals();
    $kernel = Kernel::getInstance();
    $response = $kernel->handle($request);
    $response->send();

} catch (ResourceNotFoundException $e) {
    echo $e->getMessage();
}