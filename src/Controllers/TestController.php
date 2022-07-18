<?php

declare(strict_types=1);

namespace PetFoundation\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PetFoundation\HelloWorld;

class TestController {

    private $helloWorld;

    public function __construct(HelloWorld $helloWord) {
        $this->helloWorld = $helloWord;
    }
    public function __invoke(){
        $texto = $this->helloWorld->pruebaInjeccion();
        echo $texto;
        $response = new Response();
        return $response->setContent('Hola');
    }

    public function test(){
        return $response->setContent('Hola');
    }

    public function loq() {
        return $this->helloWorld;
    }
}