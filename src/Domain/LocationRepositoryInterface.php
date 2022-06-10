<?php
declare(strict_types = 1);
namespace Src\Domain;

Interface LocationRepositoryInterface {
    public function save(Location $location): void;
}