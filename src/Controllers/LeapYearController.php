<?php

namespace PetFoundation\Controllers;

use Symfony\Component\HttpFoundation\Response;

class LeapYearController
{
    public function index($year = 2022) {
        if(is_leap_year($year)) {
          return new Response('Si es año viciesto');
        }
        return new Response('No es año viciesto');
    }
}