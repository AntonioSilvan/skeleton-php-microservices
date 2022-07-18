<?php
require_once __DIR__.'./vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;

function render_template($request) {
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__.'/src/pages/%s.php', $_route);

    return new Response(ob_get_clean());
}

$request = Request::createFromGlobals();
$routes = include __DIR__.'/src/app.php';

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

$controllerResolver = new HttpKernel\Controller\ControllerResolver();
$argumentsResolver = new HttpKernel\Controller\ArgumentResolver();

try{
    $request->attributes->add($matcher->match($request->getPathInfo()));

    $controller = $controllerResolver->getController($request);
    $arguments = $argumentsResolver->getArguments($request, $controller);

    $response = call_user_func($controller, $arguments);
} catch(Routing\Exception\ResourceNotFoundException $exception) {
    $response = new Response('Not found', 404);
} catch (Exception $exception) {
    $response = new Response('An error occurred', 500);
}

$response->send();