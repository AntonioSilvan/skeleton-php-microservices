<?php
declare(strict_types=1);

namespace PetFoundation\Http;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Finder\Finder;

class Kernel extends HttpKernel {
    public static $kernel = NULL;

    public static function getInstance() {
        if(empty(self::$kernel)) {
            $dispatcher = new EventDispatcher();
            $controllerResolver = new ControllerResolver();
            $requestStack = new RequestStack();
            $argumentResolver = new ArgumentResolver();
            self::$kernel = new Kernel($dispatcher, $controllerResolver, $requestStack, $argumentResolver);
        }
        return self::$kernel;
    }

    public function handle(Request $request, $type = HttpKernelInterface::MAIN_REQUEST, $catch = true) {
        $routes = self::getCompleteRouteCollection();
        $context = new RequestContext();
        $context->fromRequest($request);

        $matcher = new UrlMatcher($routes, $context);
        $parameters = $matcher->match($request->getPathInfo());
        $request->attributes->add($parameters);
        return parent::handle($request, $type, $catch);
    }

    public static function getCompleteRouteCollection() {
        $routes = new RouteCollection();
        $yamlLocations = [ __DIR__ . '/../routes' ];

        $fileLocator = new FileLocator();
        $yamlFileLoader = new YamlFileLoader($fileLocator);

        $finder = new Finder();
        $finder->files()->in($yamlLocations)->name('*.yml');

        foreach ($finder as $file) {
            $newRoutes = $yamlFileLoader->load($file->getRealPath());
            $routes->addCollection($newRoutes);
        }

        return $routes;
    }
}