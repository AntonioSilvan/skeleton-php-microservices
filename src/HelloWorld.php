<?php
declare(strict_types = 1);

namespace PetFoundation;

use Psr\Http\Message\ResponseInterface;

class HelloWorld
{
    public function __construct()
    {

    }

    public function pruebaInjeccion(): string {
        return "Texto retorno";
    }
}